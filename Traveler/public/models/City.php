<?php

namespace models;

use core\Core;
use core\Utils;

class City
{
    public static string $table = 'City';

    public static function getCityListById($country_id): array
    {
        return Core::getInstance()->db->select(self::$table, ['*'], ['country_id' => $country_id]);
    }

    public static function getCityByLink(string $link): ?array
    {
        $query_result = Core::getInstance()->db->select(self::$table, ['*'], [
            'link' => $link
        ]);
        return $query_result[0] ?? null;
    }

    public static function getCityById(int $id): ?array
    {
        $query_result = Core::getInstance()->db->select(self::$table, ['*'], [
            'city_id' => $id
        ]);
        return $query_result[0] ?? null;
    }

    public static function addCity($country_id, $name, $link, $flag): void {
        $flag_file_name = Utils::uploadFile($flag, "files/countries/city/", Utils::$imgAllowedTypes);
        Core::getInstance()->db->insert(self::$table, [
            'country_id' => $country_id,
            'name' => $name,
            'link' => $link,
            'flag' => $flag_file_name,
        ]);
    }

    public static function updateCity($city_id, $city_name, $link, $flag): void {
        $city = Core::getInstance()->db->select(self::$table, ['*'], [
            'city_id' => $city_id
        ])[0];

        $flag_file_name = $city['flag'];
        if ($flag)
        {
            unlink('files/countries/city/' . $city['flag']);
            $flag_file_name = Utils::uploadFile($flag, "files/countries/city/", Utils::$imgAllowedTypes);
        }

        Core::getInstance()->db->update(self::$table, [
            'name' => $city_name,
            'link' => $link,
            'flag' => $flag_file_name
        ], 'city_id', $city_id);
    }

    public static function deleteCity($city_id): void
    {
        $city = Core::getInstance()->db->select(self::$table, ['*'], [
            'city_id' => $city_id
        ])[0];
        unlink('files/countries/city/' . $city['flag']);
        Core::getInstance()->db->delete(self::$table, 'city_id', $city_id);
    }
}