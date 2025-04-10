<?php

namespace core;

use Cassandra\Date;

class Utils
{
    public static array $onlySvgAllowed = [
        'image/svg+xml' => 'svg'
    ];
    public static array $imgAllowedTypes = [
        'image/png' => 'png',
        'image/jpeg' => 'jpg',
        'image/svg+xml' => 'svg',
        'image/webp' => 'webp',
        'image/avif' => 'avif'
    ];

    public static array $videoAllowedTypes = [
        'video/mp4' => 'mp4',
        'video/webm' => 'webm'
    ];

    public static function uploadFile($file, $path, $allowedTypes): string
    {
        do {
            $file_name = uniqid() . '.' . $allowedTypes[$file['type']];
            $file_path = $path . $file_name;
        } while (file_exists($file_path));

        move_uploaded_file($file['tmp_name'], $file_path);
        return  $file_name;
    }

    public static function formatString(string $string): string
    {
        $text = "";
        while (str_contains($string, "\n"))
        {
            $temp =  substr($string, 0, strpos($string, "\n"));
            $string = str_replace($temp . "\n", '', $string);
            $text .= '<p>' . $temp . '</p>';
        }
        $text .= '<p>' . $string . '</p>';

        return $text;
    }

    public static function formatedDays(int $days): string
    {
        if (($days % 10 >= 5 && $days % 10 <= 9) || ($days % 10 == 0) || ($days >= 11 && $days <= 15))
            return "$days ночей";
        else if ($days % 10 == 1)
            return "$days ніч";
        else
            return "$days ночі";
    }

    public static function formatedTourists(int $tourists): string
    {
        if (($tourists % 10 >= 5 && $tourists % 10 <= 9) || ($tourists % 10 == 0) || ($tourists >= 11 && $tourists <= 15))
            return "$tourists людей";
        else if ($tourists % 10 == 1)
            return "$tourists людину";
        else
            return "$tourists людини";
    }

    public static function trueFormatedTourists(int $tourists): string
    {
        if (($tourists % 10 >= 5 && $tourists % 10 <= 9) || ($tourists % 10 == 0) || ($tourists >= 11 && $tourists <= 15))
            return "$tourists туристів";
        else if ($tourists % 10 == 1)
            return "$tourists турист";
        else
            return "$tourists туристи";
    }

    public static function formatedRooms(int $rooms): string
    {
        if (($rooms % 10 >= 5 && $rooms % 10 <= 9) || ($rooms % 10 == 0) || ($rooms >= 11 && $rooms <= 15))
            return "Залишилось $rooms кімнат";
        else if ($rooms % 10 == 1)
            return "Залишилася $rooms кімната";
        else
            return "Залишилося $rooms кімнати";
    }

    public static function shortFormatedRooms(int $rooms): string
    {
        if (($rooms % 10 >= 5 && $rooms % 10 <= 9) || ($rooms % 10 == 0) || ($rooms >= 11 && $rooms <= 15))
            return "$rooms кімнат";
        else if ($rooms % 10 == 1)
            return "$rooms кімната";
        else
            return "$rooms кімнати";
    }

    public static function formatedPrice(float $price): string
    {
        return "UAH " . number_format($price, 2, '.', ',');
    }


    private static array $monthArray = ["січня", "лютого", "березня", "квітня", "травня", "червня", "липня", "серпня", "вересня", "жовтня", "листопада"];
    public static function fullDate(int $date): string
    {
        $day = date("j", $date);
        $month = intval(date("m", $date));
        $year = date("Y", $date);

        return "$day " . self::$monthArray[$month - 1] . " $year р.";
    }
}