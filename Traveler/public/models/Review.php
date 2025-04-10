<?php

namespace models;

use core\Core;

class Review
{
    public static string $table = 'Review';
    public static int $page_offset = 2;

    public static function getReviewsList($page): array
    {
        return Core::getInstance()->db->select(self::$table, page_i: $page, page_offset: self::$page_offset, order: "review_id desc");
    }

    public static function addReview($author_id, $text, $photo_list): void
    {
        $allowedTypes = [
            'image/png' => 'png',
            'image/jpeg' => 'jpg'
        ];

        $photo_json = [];
        if (!empty($photo_list))
            for ($i = 0; $i < count($photo_list['name']); $i++) {
                if ($photo_list['size'][$i] == 0)
                    break;

                do {
                    $file_name = uniqid() . '.' . $allowedTypes[$photo_list['type'][$i]];
                    $file_path = "files/review_photos/" . $file_name;
                } while (file_exists($file_path));

                $photo_json[] = $file_name;
                move_uploaded_file($photo_list['tmp_name'][$i], $file_path);
            }

        Core::getInstance()->db->insert(self::$table, [
            "author_id" => $author_id,
            "text" => $text,
            "photo_json" => json_encode($photo_json),
            "date" => date("Y-m-d")
        ]);
    }

    public static function deleteReview($review_id): void
    {
        $review = Core::getInstance()->db->select(self::$table, ["*"], [
            "review_id" => $review_id
        ])[0] ?? null;
        if ($review != null) {
            $filesArray = json_decode($review['photo_json'], true);
            foreach ($filesArray as $file)
                unlink("files/review_photos/" . $file);
        }
        Core::getInstance()->db->delete(self::$table, "review_id", $review_id);
    }

    public static function isUserReview($review_id, $user_id): bool
    {
        return !empty(Core::getInstance()->db->select(table:self::$table, conditions:[
            "review_id" => $review_id,
            "author_id" => $user_id
        ]));
    }

    public static function getPagesCount(): int
    {
        return ceil(Core::getInstance()->db->select(table:self::$table, fields:["COUNT(*)"])[0]["COUNT(*)"] / self::$page_offset);
    }
}