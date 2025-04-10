<?php

namespace controllers;

use core\Controller;
use core\Core;
use core\Utils;
use models\Booking;
use models\Country;
use models\Facility;
use models\Room;
use models\Saved;
use models\Tour;
use models\User;

class ToursController extends Controller
{
    function indexAction()
    {
        return $this->render(params: [
            'searchParams' => [],
            'header_page' => 'tours',
            'countriesArray' => Country::getCountriesList()
        ]);
    }

    function searchAction()
    {
        return $this->render(path: "views/tours/search_page/index.php", params: [
            'searchParams' => $_GET,
            'header_page' => 'tours',
            'countriesArray' => Country::getCountriesList(),
            'tourFacilities' => Facility::getFacilities("TourFacility"),
            'roomFacilities' => Facility::getFacilities("RoomFacility"),
        ]);
    }



    function json_searchAction()
    {
        if (Core::getInstance()->requestMethod != "POST")
            $this->error(404);

        $page = intval($_POST['page'] ?? 0);

        $name = $_POST['name'] ?? null;
        $country = $_POST['country'] ?? null;
        $city = $_POST['city'] ?? null;

        $date = $_POST['date'] ?? null;
        $days = $_POST['days'] ?? null;
        $tourists = $_POST['tourists'] ?? null;

        $stars = $_POST['stars'] ?? null;
        $price_range = $_POST['price_range'] ?? null;
        if ($price_range)
            $price_range = (array)json_decode($price_range);
        $tour_facilities = $_POST['tour_facilities'] ?? null;
        if ($tour_facilities)
            $tour_facilities = json_decode($tour_facilities);
        $room_facilities = $_POST['room_facilities'] ?? null;
        if ($room_facilities)
            $room_facilities = json_decode($room_facilities);

        $tours = Tour::search($page, $name, $country, $city, $stars, $price_range, $tour_facilities, $room_facilities);

        header('Content-type: application/json');
        echo json_encode($tours);
    }

    function viewAction($params)
    {
        $tour = Tour::getTourByLink($params[0]);
        if (empty($tour))
            return $this->error(404);

        $date = $_GET['date'] ?? date('d/m/Y');
        $date_int = strtotime($_GET['date'] ?? date('d-m-Y'));
        $days = $_GET['days'] ?? 1;
        $tourists = $_GET['tourists'] ?? 1;

        foreach ($tour['rooms'] as $room_i => $room) {
            $left = $room['count'];
            for ($i = 0; $i < $days; $i++)
            {
                $temp_date = date("Y-m-d", $date_int + $i * 24 * 60 * 60);
                $left = min($left, Booking::roomBookingCount($room['room_id'], $temp_date));
            }
            $tour['rooms'][$room_i]['left'] = $left;
        }

        $similarTours = [];
        $sameCityTours = Tour::search(0, country: $tour['country']['en_name'], city: $tour['city']['link']);
        foreach ($sameCityTours as $sameCityTour)
            if ($sameCityTour['tour_id'] != $tour['tour_id'])
                $similarTours[] = $sameCityTour;
        $similarTours = array_slice($similarTours, 0, 4);

        if (count($similarTours) < 4) {
            $sameCountryTours = Tour::search(0, country: $tour['country']['en_name']);
            foreach ($sameCountryTours as $sameCountryTour) {
                $isUsedBefore = false;
                foreach ($similarTours as $similarTour)
                    if ($sameCountryTour['tour_id'] == $similarTour['tour_id'] || $sameCountryTour['tour_id'] == $tour['tour_id']) {
                        $isUsedBefore = true;
                        break;
                    }
                if (!$isUsedBefore)
                    $similarTours[] = $sameCountryTour;
            }
            $similarTours = array_slice($similarTours, 0, 4);

            if (count($similarTours) < 4) {
                $sameNothingTours = Tour::search(0);
                foreach ($sameNothingTours as $sameNothingTour) {
                    $isUsedBefore = false;
                    foreach ($similarTours as $similarTour)
                        if ($sameNothingTour['tour_id'] == $similarTour['tour_id'] || $sameNothingTour['tour_id'] == $tour['tour_id']) {
                            $isUsedBefore = true;
                            break;
                        }
                    if (!$isUsedBefore)
                        $similarTours[] = $sameNothingTour;
                }
                $similarTours = array_slice($similarTours, 0, 4);
            }
        }

        $tour['description'] = Utils::formatString($tour['description']);

        return $this->render(path: "views/tours/view/index.php", params: [
            'header_page' => 'tours',
            'tour' => $tour,
            'searchParams' => [
                'date' => $date,
                'days' => intval($days),
                'tourists' => intval($tourists)
            ],
            'similarTours' => $similarTours
        ]);
    }

    function saveAction()
    {
        if (!User::isLogUser())
            return $this->error(403);
        if (Core::getInstance()->requestMethod != "POST")
            return $this->error(405);

        if (User::isLogUser())
        {
            $user_id = User::getCurrentUser()['id'];
            $tour_id = $_POST['tour_id'];
            Saved::saveTour($tour_id, $user_id);
            http_response_code(200);
            die();
        }
        else
            $this->error(403);
    }

    public function addAction()
    {
        if (!User::isCurrentUserModerator())
            return $this->render("views/error/index.php", [
                'error' => "404"
            ]);

        if (Core::getInstance()->requestMethod == "POST") {
            Tour::addTour(...$this->getData());
            $this->redirect("/admin");
        }

        return $this->render(path: 'views/admin/tour_admin/tour_editor/index.php', params: [
            'countryArray' => Country::getCountriesList(),
            'tourFacilities' => Facility::getFacilities("TourFacility"),
            'roomFacilities' => Facility::getFacilities("RoomFacility")
        ]);
    }

    public function editAction($params)
    {
        if (!User::isCurrentUserModerator() || !isset($params[0]))
            return $this->render("views/error/index.php", [
                'error' => "404"
            ]);


        if (Core::getInstance()->requestMethod == "POST") {
            Tour::editTour($_POST['tour_id'], ...$this->getData());
            $this->redirect("/admin");
        }

        return $this->render(path: 'views/admin/tour_admin/tour_editor/index.php', params: [
            'countryArray' => Country::getCountriesList(),
            'tourFacilities' => Facility::getFacilities("TourFacility"),
            'roomFacilities' => Facility::getFacilities("RoomFacility"),
            'tour' => Tour::getTourByLink($params[0])
        ]);
    }

    public function deleteAction()
    {
        if (!User::isCurrentUserModerator() || Core::getInstance()->requestMethod != "POST")
            return $this->render("views/error/index.php", [
                'error' => "404"
            ]);

        $tour_id = $_POST["tour_id"];
        Tour::deleteTour($tour_id);
    }

    private function getData(): array
    {
        $name =  $_POST['name'] ?? "";
        $link = $_POST['link'] ?? uniqid();
        $stars = $_POST['stars'] ?? "2";
        $country_id = $_POST['country'] ?? 6;
        $city_id = $_POST['city'] ?? 20;
        $description = $_POST['description'] ?? "";
        $address = $_POST['address'] ?? "";
        $google_maps_link = $_POST['google_maps_link'] ?? "";
        $location_longitude = $_POST['coordinate_x'] ?? "0";
        $location_latitude = $_POST['coordinate_y'] ?? "0";
        $tour_facilities = $_POST['tour_facilities'] ?? [];

        $photo_list = [];
        if (!empty($_FILES['photo_list']['name'][0]))
            foreach ($_FILES['photo_list']['name'] as $i => $photo)
            {
                $photo_list[] = [
                    'type' => $_FILES['photo_list']['type'][$i],
                    'tmp_name' => $_FILES['photo_list']['tmp_name'][$i]
                ];
            }

        $rooms_array = [
            'edited' => [],
            'new' => []
        ];

        if (isset($_POST['room_name']))
            foreach ($_POST['room_name'] as $i => $room_name)
            {
                if (isset($_POST['room_id'][$i]))
                {
                    $room = $this->getRoomData($i);
                    $room['room_id'] = $_POST['room_id'][$i];

                    $rooms_array['edited'][] = $room;
                } else
                    $rooms_array['new'][] = $this->getRoomData($i);
            }

        return [$country_id, $city_id, $name, $link, $description, $photo_list, $stars,
            $address, $google_maps_link, $location_longitude, $location_latitude, $tour_facilities, $rooms_array];
    }

    private function getRoomData($i): array
    {
        $room = [
            'name' => $_POST['room_name'][$i],
            'description' => $_POST['room_description'][$i],
            'photo_list' => [],
            'price' => $_POST['room_price'][$i],
            'count' => $_POST['room_count'][$i],
            'capacity' => $_POST['room_capacity'][$i],
            'facilities' => $_POST['room_facilities'][$i] ?? [],
        ];

        if (isset($_FILES['room_photo_list']['name'][$i])) {
            foreach ($_FILES['room_photo_list']['name'][$i] as $j => $photo)
            if (!empty($photo))
                {
                    $room['photo_list'][] = [
                        'type' => $_FILES['room_photo_list']['type'][$i][$j],
                        'tmp_name' => $_FILES['room_photo_list']['tmp_name'][$i][$j]
                    ];
                }
        }

        return $room;
    }
}