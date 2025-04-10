<?php

namespace models;

use core\Core;
use core\Utils;

class Facility
{
    public static function getFacilities($table): array
    {
        return Core::getInstance()->db->select($table, ['*']);
    }

    public static function getFacilitiesForTour($tour_id): array
    {
        return Core::getInstance()->db->select("Tour_TourFacility", ['*'], [
            'tour_id' => $tour_id
        ]);
    }

    public static function getFacilitiesArrayForTour($tour_id): array
    {
        $tour_tourFacilities = Core::getInstance()->db->select("Tour_TourFacility", ['*'], [
            'tour_id' => $tour_id
        ]) ?? [];

        $facilities = [];
        foreach ($tour_tourFacilities as $tour_facility)
            $facilities[] = Core::getInstance()->db->select("TourFacility", ['*'], [
                'facility_id' => $tour_facility['facility_id']
            ])[0];

        return $facilities;
    }

    public static function getFacilitiesForRoom($room_id): array
    {
        return Core::getInstance()->db->select("Room_RoomFacility", ['*'], [
            'room_id' => $room_id
        ]);
    }

    public static function getFacilitiesListForRoom($room_id): array
    {
        $room_roomFacilities = Core::getInstance()->db->select("Room_RoomFacility", ['*'], [
            'room_id' => $room_id
        ]) ?? [];

        $facilities = [];
        foreach ($room_roomFacilities as $room_facility)
            $facilities[] = Core::getInstance()->db->select("RoomFacility", ['*'], [
                'facility_id' => $room_facility['facility_id']
            ])[0];

        return $facilities;
    }

    public static function addFacility($table, $name, $icon): void
    {
        $icon_file_name = Utils::uploadFile($icon, 'files/facilities/', Utils::$onlySvgAllowed);
        Core::getInstance()->db->insert($table, [
            'name' => $name,
            'icon' => $icon_file_name
        ]);
    }

    public static function addTourFacilities($tour_id, $tour_facilities): void
    {
        foreach ($tour_facilities as $facility_id)
            Core::getInstance()->db->insert("Tour_TourFacility", [
                'tour_id' => $tour_id,
                'facility_id' => $facility_id
            ]);
    }

    public static function addRoomFacilities($room_id, $room_facilities): void
    {
        foreach ($room_facilities as $facility_id)
            Core::getInstance()->db->insert("Room_RoomFacility", [
                'room_id' => $room_id,
                'facility_id' => $facility_id
            ]);
    }

    public static function updateFacility($table, $id, $name, $icon): void
    {
        $facility = Core::getInstance()->db->select($table, ['*'], [
            'facility_id' => $id
        ])[0];

        $icon_file_name = $facility['icon'];
        if ($icon)
        {
            unlink('files/facilities/' . $facility['icon']);
            $icon_file_name = Utils::uploadFile($icon, "files/facilities/", Utils::$onlySvgAllowed);
        }

        Core::getInstance()->db->update($table, [
            'name' => $name,
            'icon' => $icon_file_name
        ], 'facility_id', $id);
    }

    public static function deleteFacility($table, $id): void
    {
        $facility = Core::getInstance()->db->select($table, ['*'], [
            'facility_id' => $id
        ])[0];
        unlink('files/facilities/' . $facility['icon']);
        core::getInstance()->db->delete($table, 'facility_id', $id);
    }

    public static function deleteTourFacilities($tour_id): void
    {
        Core::getInstance()->db->delete("Tour_TourFacility", 'tour_id', $tour_id);
    }

    public static function deleteRoomFacilities($room_id): void
    {
        Core::getInstance()->db->delete("Room_RoomFacility", 'room_id', $room_id);
    }
}