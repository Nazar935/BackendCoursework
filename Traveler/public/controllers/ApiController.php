<?php

namespace controllers;

use core\Controller;
use core\Core;
use models\User;

class ApiController extends Controller
{
    public function is_uniqueAction()
    {
        if (Core::getInstance()->requestMethod == 'POST' && User::isCurrentUserModerator())
        {
            $table = $_POST['table'];
            $column = $_POST['column'];
            $value = $_POST['value'];

            $result = Core::getInstance()->db->select($table, ["*"], [
                $column => $value
            ])[0] ?? false;
            header('Content-type: application/json');
            echo json_encode(!$result);
            die;
        }
        return $this->error(404);
    }
}