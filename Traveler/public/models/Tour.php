<?php

namespace models;

use core\Core;
use core\Utils;

class Tour
{
    public static string $table = 'Tour';
    public static int $page_offset = 5;

    public static function getToursList(): array
    {
        $toursArray = Core::getInstance()->db->select(static::$table);

        return self::validateToursArray($toursArray);
    }

    public static function search(int $page, string $name = null, string $country = null, string $city = null, string $stars = null,
                                  array $price_range = null, array $tour_facilities = null, array $room_facilities = null): array
    {
        $max_n = ($page + 1) * self::$page_offset;
        $conditions = [];
        if (!empty($country)) {
            $country_id = Country::getCountryByName($country)['country_id'] ?? null;
            if ($country_id)
                $conditions['country_id'] = $country_id;
        }
        if (!empty($city)) {
            $city_id = City::getCityByLink($city)['city_id'] ?? null;
            if ($city_id)
                $conditions['city_id'] = $city_id;
        }
        if (!empty($stars))
            $conditions['stars'] = $stars;

        $queryResult = Core::getInstance()->db->select(static::$table, ["*"], $conditions, search: ['name' => $name]);

        $toursArrayAfterTourFacilitySelection = [];
        if ($tour_facilities && $queryResult)
        {
            foreach ($queryResult as $tour) {
                $facilities = Facility::getFacilitiesForTour($tour['tour_id']);
                $facilitySelectorPass = true;
                for ($i = 0; $i < count($tour_facilities); $i++)
                {
                    $isInFacilities = false;
                    for ($j = 0; $j < count($facilities); $j++)
                        if ($facilities[$j]['facility_id'] == $tour_facilities[$i]) {
                            $isInFacilities = true;
                            break;
                        }
                    if (!$isInFacilities) {
                        $facilitySelectorPass = false;
                        break;
                    }
                }
                if ($facilitySelectorPass) {
                    $toursArrayAfterTourFacilitySelection[] = $tour;
                    if (count($toursArrayAfterTourFacilitySelection) >= $max_n)
                        break;
                }
            }
        } else
            $toursArrayAfterTourFacilitySelection = $queryResult;

        $toursArrayAfterRoomFacilitiesSelection = [];
        if ($room_facilities && $toursArrayAfterTourFacilitySelection)
        {
            foreach ($toursArrayAfterTourFacilitySelection as $tour) {
                $roomsArray = Room::getRoomsForTour($tour['tour_id']);
                foreach ($roomsArray as $room)
                {
                    $facilitySelectorPass = true;
                    for ($i = 0; $i < count($room_facilities); $i++)
                    {
                        $isInFacilities = false;
                        for ($j = 0; $j < count($room['facilities']); $j++)
                            if ($room_facilities[$i] == $room['facilities'][$j]['facility_id']) {
                                $isInFacilities = true;
                                break;
                            }
                        if (!$isInFacilities) {
                            $facilitySelectorPass = false;
                            break;
                        }
                    }
                    if ($facilitySelectorPass) {
                        $toursArrayAfterRoomFacilitiesSelection[] = $tour;
                        break;
                    }
                }
            }
        } else
            $toursArrayAfterRoomFacilitiesSelection = $toursArrayAfterTourFacilitySelection;
        $toursArray = $toursArrayAfterRoomFacilitiesSelection;

        $toursArrayAfterPriceFilter = [];
        foreach ($toursArray as $tour_index => $tour) {
            $rooms = Room::getRoomsForTour($tour['tour_id']);
            $minPrice = $rooms[0]['price'];
            foreach ($rooms as $room_index => $room)
                if ($minPrice > $room['price'])
                    $minPrice = $room['price'];
            $toursArray[$tour_index]['min_price'] = Utils::formatedPrice($minPrice);

            if ($price_range)
                if ($minPrice > $price_range['left'] && $minPrice < $price_range['right'])
                    $toursArrayAfterPriceFilter[] = $toursArray[$tour_index];
        }
        if ($price_range)
            $toursArray = $toursArrayAfterPriceFilter;

        $toursArray = array_slice($toursArray, $page * self::$page_offset, self::$page_offset);
        return self::validateToursArray($toursArray);
    }

    public static function getTourByLink(string $link): array|null
    {
        $tour = Core::getInstance()->db->select(static::$table, ['*'], ["link" => $link])[0] ?? null;

        if ($tour) {
            $tour = self::validateTour($tour);
            $tour['facilities'] = Facility::getFacilitiesForTour($tour['tour_id']);
            $tour['facilities_array'] = Facility::getFacilitiesArrayForTour($tour['tour_id']);
            $tour['rooms'] = Room::getRoomsForTour($tour['tour_id']);
        }

        return $tour;
    }

    public static function getTourById(string $tourId): array|null
    {
        $tour = Core::getInstance()->db->select(static::$table, ['*'], ["tour_id" => $tourId])[0] ?? null;
        if ($tour)
            $tour = self::validateTour($tour);
        return $tour;
    }

    public static function validateToursArray(array|null $toursArray): array|null
    {
        $toursArray = $toursArray ?? [];
        foreach ($toursArray as $i => $tour)
            $toursArray[$i] = self::validateTour($tour);
        return $toursArray;
    }

    public static function validateTour(array|null $tour): array|null
    {
        if (!empty($tour)) {
            $tour['photo_list'] = json_decode($tour['photo_list']);
            $tour['stars'] = intval($tour['stars']);
            $tour['country'] = Country::getCountryById($tour['country_id']);
            $tour['city'] = City::getCityById($tour['city_id']);

            if (User::isLogUser())
                $tour['is_saved'] = Saved::isSavedTour($tour['tour_id'], User::getCurrentUser()['id']);
            else
                $tour['is_saved'] = false;
        }

        return $tour;
    }

    public static function addTour($country_id, $city_id, $name, $link, $description, $photo_list, $stars, $address,
                                   $google_maps_link, $location_longitude, $location_latitude, $tour_facilities, $rooms_array): void
    {
        $photo_list_file_names = [];
        foreach ($photo_list as $photo)
        {
            $photo_list_file_names[] = Utils::uploadFile($photo, 'files/tours/pictures/', Utils::$imgAllowedTypes);
        }

        Core::getInstance()->db->insert(static::$table, [
            'country_id' => $country_id,
            'city_id' => $city_id,
            'name' => $name,
            'link' => $link,
            'description' => $description,
            'photo_list' => json_encode($photo_list_file_names),
            'stars' => $stars,
            'address' => $address,
            'google_maps_link' => $google_maps_link,
            'location_longitude' => $location_longitude,
            'location_latitude' => $location_latitude
        ]);

        $tour_id = Core::getInstance()->db->select(self::$table, ['tour_id'], page_offset: 1, order: "tour_id desc")[0]['tour_id'];

        Facility::addTourFacilities($tour_id, $tour_facilities);

        foreach ($rooms_array['new'] as $room)
            Room::addRoom($tour_id, $room['name'], $room['description'], $room['photo_list'],
                $room['price'], $room['count'], $room['capacity'], $room['facilities']);
    }

    public static function editTour($tour_id, $country_id, $city_id, $name, $link, $description, $photo_list, $stars, $address,
                                    $google_maps_link, $location_longitude, $location_latitude, $tour_facilities, $rooms_array): void
    {
        $tour = Core::getInstance()->db->select(self::$table, ["*"], [
            'tour_id' => $tour_id,
        ])[0];

        Core::getInstance()->db->update(self::$table, [
            'country_id' => $country_id,
            'city_id' => $city_id,
            'name' => $name,
            'link' => $link,
            'description' => $description,
            'stars' => $stars,
            'address' => $address,
            'google_maps_link' => $google_maps_link,
            'location_longitude' => $location_longitude,
            'location_latitude' => $location_latitude
        ], 'tour_id', $tour_id);

        if (!empty($photo_list)) {
            $photo_list_file_names = json_decode($tour['photo_list']);
            foreach ($photo_list_file_names as $photo)
                unlink("files/tours/pictures/" . $photo);
            $photo_list_file_names = [];

            foreach ($photo_list as $photo)
                $photo_list_file_names[] = Utils::uploadFile($photo, 'files/tours/pictures/', Utils::$imgAllowedTypes);

            Core::getInstance()->db->update(self::$table, [
                'photo_list' => json_encode($photo_list_file_names)
            ], 'tour_id', $tour_id);
        }

        Facility::deleteTourFacilities($tour_id);
        Facility::addTourFacilities($tour_id, $tour_facilities);

        $rooms_before = Room::getRoomsForTour($tour_id);
        $rooms_id_array = [];

        foreach ($rooms_array['edited'] as $room)
        {
            $rooms_id_array[] = $room['room_id'];
            Room::editRoom($room['room_id'], $room['name'], $room['description'], $room['photo_list'],
                $room['price'], $room['count'], $room['capacity'], $room['facilities']);
        }

        foreach ($rooms_before as $room)
            if (!in_array($room['room_id'], $rooms_id_array))
                Room::deleteRoom($room['room_id']);

        foreach ($rooms_array['new'] as $room)
            Room::addRoom($tour_id, $room['name'], $room['description'], $room['photo_list'],
                $room['price'], $room['count'], $room['capacity'], $room['facilities']);


    }

    public static function deleteTour($tour_id): void
    {
        $tour = Core::getInstance()->db->select(self::$table, ["*"], [
            'tour_id' => $tour_id,
        ])[0];

        $photo_list_file_names = json_decode($tour['photo_list']);
        foreach ($photo_list_file_names as $photo)
            unlink("files/tours/pictures/" . $photo);

        $rooms = Room::getRoomsForTour($tour_id);
        foreach ($rooms as $room)
            Room::deleteRoom($room['room_id']);

        Core::getInstance()->db->delete(self::$table, 'tour_id', $tour_id);
    }
}