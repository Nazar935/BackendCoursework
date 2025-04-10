<?php

namespace models;

use core\Core;

class Question
{
    public static string $table = 'FAQ';
    public static function getQuestionsList(): array
    {
        return Core::getInstance()->db->select(self::$table, order: "list_order");
    }

    public static function deleteQuestion($id): void
    {
        Core::getInstance()->db->delete(self::$table, "question_id", $id);
    }

    public static function editQuestion($id, $params): void
    {
        Core::getInstance()->db->update(self::$table, $params, "question_id", $id);
    }

    public static function addQuestion($question, $answer, $list_order): void
    {
        Core::getInstance()->db->insert(self::$table, [
            "question" => $question,
            "answer" => $answer,
            "list_order" => $list_order
        ]);
    }

    public static function changeListOrder($id, $list_order): void
    {
        Core::getInstance()->db->call("changeListOrder", [
            $id,
            $list_order
        ]);
    }
}