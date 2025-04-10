<?php

namespace controllers;

use core\Controller;
use core\Core;
use models\Facility;
use models\User;

class FacilityController extends Controller
{
    public function addAction($params)
    {
        if (!User::isCurrentUserModerator())
            return $this->render("views/error/index.php", [
                'error' => "404"
            ]);

        $table = $this::validateTable($params[0]);

        if (Core::getInstance()->requestMethod == 'POST')
        {
            $name = $_POST['facility_name'];
            $icon = [
                'type' => $_FILES['facility_icon']['type'],
                'tmp_name' => $_FILES['facility_icon']['tmp_name']
            ];

            Facility::addFacility($table, $name, $icon);
            $this->message("Зручність додано", "positive");
        }

        $this->redirect("/admin");
    }

    public function editAction($params)
    {
        if (!User::isCurrentUserModerator())
            return $this->render("views/error/index.php", [
                'error' => "404"
            ]);

        $table = $this::validateTable($params[0]);

        if (Core::getInstance()->requestMethod == 'POST')
        {
            $id = $_POST['facility_id'];
            $name = $_POST['facility_name'];
            $icon = $_FILES['facility_icon']['name']? $_FILES['facility_icon'] : null;

            Facility::updateFacility($table, $id, $name, $icon);
            $this->message("Зручність змінено", "positive");
        }

        $this->redirect("/admin");
    }

    public function deleteAction($params)
    {
        if (!User::isCurrentUserModerator())
            return $this->render("views/error/index.php", [
                'error' => "404"
            ]);

        $table = $this::validateTable($params[0]);

        if (Core::getInstance()->requestMethod == 'POST')
        {
            $id = $_POST['facility_id'];
            Facility::deleteFacility($table, $id);
            $this->message("Зручність видалено", "neutral");
        }

        die();
    }

    private function validateTable($table): string
    {
        if ($table == 'tour_facility')
            $table = 'TourFacility';
        if ($table == 'room_facility')
            $table = 'RoomFacility';
        return $table;
    }
}