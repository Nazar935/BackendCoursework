<?php

namespace models;

use core\Core;
use core\Utils;

class Room
{
    public static string $table = 'Room';
    public static string $facilityTable = 'Room_RoomFacility';

    public static function getRoomsForTour($tour_id) : array
    {
        $rooms = Core::getInstance()->db->select(self::$table, ['*'], [
            'tour_id' => $tour_id
        ]);
        foreach ($rooms as $i => $room) {
            $rooms[$i]['facilities'] = Facility::getFacilitiesForRoom($room['room_id']);
            $rooms[$i]['facilities_list'] = Facility::getFacilitiesListForRoom($room['room_id']);
            $rooms[$i]['photo_list'] = json_decode($rooms[$i]['photo_list']);
        }

        return $rooms;
    }

    public static function getRoomById(int $room_id): array|null
    {
        return Core::getInstance()->db->select(self::$table, ['*'], [
            'room_id' => $room_id
        ])[0] ?? null;
    }
    public static function addRoom($tour_id, $name, $description, $photo_list, $price, $count, $capacity, $facilities_array): void
    {
        $photo_list_file_names = [];
        foreach ($photo_list as $photo)
            $photo_list_file_names[] = Utils::uploadFile($photo, 'files/tours/rooms/', Utils::$imgAllowedTypes);

        $photo_list_file_names = json_encode($photo_list_file_names);
        $price = str_replace(",", "", $price);

        Core::getInstance()->db->insert(self::$table, [
            'tour_id' => $tour_id,
            'name' => $name,
            'description' => $description,
            'photo_list' => $photo_list_file_names,
            'price' => $price,
            'count' => $count,
            'capacity' => $capacity
        ]);

        $room_id = Core::getInstance()->db->select(self::$table, ['room_id'], page_offset: 1, order: 'room_id desc')[0]['room_id'];

        foreach ($facilities_array as $facility_id)
            Core::getInstance()->db->insert(self::$facilityTable, [
                'room_id' => $room_id,
                'facility_id' => $facility_id
            ]);
    }

    public static function editRoom($room_id, $name, $description, $photo_list, $price, $count, $capacity, $facilities_array): void
    {
        $room = Core::getInstance()->db->select(self::$table, ["*"], [
            'room_id' => $room_id
        ])[0];
        $price = str_replace(",", "", $price);

        Core::getInstance()->db->update(self::$table, [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'count' => $count,
            'capacity' => $capacity
        ], 'room_id', $room_id);

        if (!empty($photo_list)) {
            $photo_list_file_names = json_decode($room['photo_list']);
            foreach ($photo_list_file_names as $photo)
                unlink("files/tours/rooms/$photo");
            $photo_list_file_names = [];

            foreach ($photo_list as $photo)
                $photo_list_file_names[] = Utils::uploadFile($photo, 'files/tours/rooms/', Utils::$imgAllowedTypes);

            $photo_list_file_names = json_encode($photo_list_file_names);
            Core::getInstance()->db->update(self::$table, [
                'photo_list' => $photo_list_file_names
            ], 'room_id', $room_id);
        }

        Facility::deleteRoomFacilities($room_id);
        Facility::addRoomFacilities($room_id, $facilities_array);
    }

    public static function deleteRoom($room_id): void
    {
        $room = Core::getInstance()->db->select(self::$table, ["*"], [
            'room_id' => $room_id
        ])[0];

        $photo_list = json_decode($room['photo_list']);
        foreach ($photo_list as $photo)
            unlink("files/tours/rooms/$photo");

        Core::getInstance()->db->delete(self::$table, 'room_id', $room_id);
    }
}