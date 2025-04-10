<?php

namespace models;

use core\Core;
use core\Utils;

class Country
{
    public static string $table = 'Country';

    public static function getCountriesList(): array
    {
        $countries = Core::getInstance()->db->select(self::$table);
        foreach ($countries as $i => $country)
        {
            $countries[$i]['cities'] = City::getCityListById($country['country_id']);
        }

        return $countries;
    }

    public static function getCountryByName(string $en_name): ?array
    {
        $query_result = Core::getInstance()->db->select(self::$table, ['*'], [
            'en_name' => $en_name
        ]);
        if ($query_result)
        {
            $query_result[0]['cities'] = City::getCityListById($query_result[0]['country_id']);
        }
        return $query_result[0] ?? null;
    }

    public static function getCountryById(int $id): ?array
    {
        $query_result = Core::getInstance()->db->select(self::$table, ['*'], [
            'country_id' => $id
        ]);
        if ($query_result)
        {
            $query_result[0]['cities'] = City::getCityListById($query_result[0]['country_id']);
        }
        return $query_result[0] ?? null;
    }

    public static function addCountry($ua_name, $en_name, $flag, $pattern, $video, $cover, $cities): void
    {
        $flagPath = Utils::uploadFile($flag, "files/countries/flags/", Utils::$imgAllowedTypes);
        $patternPath = Utils::uploadFile($pattern, "files/countries/patterns/", Utils::$imgAllowedTypes);
        $coverPath = Utils::uploadFile($cover, "files/countries/covers/", Utils::$imgAllowedTypes);
        $videoPath = Utils::uploadFile($video, "files/countries/videos/", Utils::$videoAllowedTypes);

        Core::getInstance()->db->insert(self::$table, [
            'ua_name' => $ua_name,
            'en_name' => $en_name,
            'flag' => $flagPath,
            'pattern' => $patternPath,
            'video' => $videoPath,
            'cover' => $coverPath
        ]);

        $country_id = Core::getInstance()->db->select(self::$table, ['country_id'], page_offset: 1, order: "country_id desc")[0]['country_id'];
        foreach ($cities as $city)
        {
            City::addCity($country_id, $city['name'], $city['link'], $city['flag']);
        }
    }


    public static function deleteCountry($country_id): void
    {
        $country = Core::getInstance()->db->select(self::$table, ['*'], [
            'country_id' => $country_id
        ])[0];
        unlink('files/countries/flags/' . $country['flag']);
        unlink('files/countries/patterns/' . $country['pattern']);
        unlink('files/countries/videos/' . $country['video']);
        unlink('files/countries/covers/' . $country['cover']);

        Core::getInstance()->db->delete(self::$table, "country_id", $country_id);
    }

    public static function editCountry($country_id, $ua_name, $en_name, $flag, $pattern, $video, $cover, $cities): void
    {
        $country = Core::getInstance()->db->select(self::$table, ['*'], [
            'country_id' => $country_id
        ])[0];
        $flag_path = $country['flag'];
        if ($flag) {
            unlink('files/countries/flags/' . $country['flag']);
            $flag_path = Utils::uploadFile($flag, "files/countries/flags/", Utils::$imgAllowedTypes);
        }
        $pattern_path = $country['pattern'];
        if ($pattern) {
            unlink('files/countries/patterns/' . $country['pattern']);
            $pattern_path = Utils::uploadFile($pattern, "files/countries/patterns/", Utils::$imgAllowedTypes);
        }
        $cover_path = $country['cover'];
        if ($cover) {
            unlink('files/countries/covers/' . $country['cover']);
            $cover_path = Utils::uploadFile($cover, "files/countries/covers/", Utils::$imgAllowedTypes);
        }

        $video_path = $country['video'];
        if ($video) {
            unlink('files/countries/videos/' . $country['video']);
            $video_path = Utils::uploadFile($video, "files/countries/videos/", Utils::$videoAllowedTypes);
        }

        Core::getInstance()->db->update(self::$table, [
            'ua_name' => $ua_name,
            'en_name' => $en_name,
            'flag' => $flag_path,
            'pattern' => $pattern_path,
            'video' => $video_path,
            'cover' => $cover_path
        ], 'country_id', $country_id);

        $cityIdArray = [];
        foreach ($cities['edited'] as $city)
        {
            City::updateCity($city['city_id'], $city['name'], $city['link'], $city['flag']);
            $cityIdArray[] = $city['city_id'];
        }

        $cityArray = City::getCityListById($country_id);
        foreach ($cityArray as $city)
            if (!in_array($city['city_id'], $cityIdArray))
                City::deleteCity($city['city_id']);

        foreach ($cities['new'] as $city)
            City::addCity($country_id, $city['name'], $city['link'], $city['flag']);
    }
}