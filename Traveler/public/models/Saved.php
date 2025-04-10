<?php

namespace models;

use core\Core;

class Saved
{
    public static string $table = 'Saved';

    public static function getSavedToursList($user_id): array
    {
        $savedTours = Core::getInstance()->db->select(self::$table, ['*'], [
            'user_id' => $user_id
        ]);

        $tours = [];
        foreach ($savedTours as $savedTour)
            $tours[] = Tour::getTourById($savedTour['tour_id']);

        return $tours;
    }

    public static function isSavedTour($tour_id, $user_id): bool
    {
        $res = Core::getInstance()->db->select(self::$table, ["*"], [
            "tour_id" => $tour_id,
            "user_id" => $user_id
        ]);

        return !empty($res[0]);
    }

    public static function saveTour($tour_id, $user_id): void
    {
        if (self::isSavedTour($tour_id, $user_id)) {
            self::deleteSave($tour_id, $user_id);
            return;
        }
        Core::getInstance()->db->insert("Saved", [
            'tour_id' => $tour_id,
            'user_id' => $user_id
        ]);
    }

    public static function deleteSave($tour_id, $user_id): void
    {
        Core::getInstance()->db->deleteWithConditions("Saved", [
            'tour_id' => $tour_id,
            'user_id' => $user_id
        ]);
    }
}