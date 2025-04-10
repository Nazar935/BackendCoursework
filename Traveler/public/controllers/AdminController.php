<?php

namespace controllers;

use core\Controller;
use core\Core;
use models\Booking;
use models\Country;
use models\Question;
use models\RoomFacility;
use models\Facility;
use models\Tour;
use models\User;

class AdminController extends Controller
{
    public function indexAction()
    {
        if (!User::isCurrentUserModerator())
            return $this->render("views/error/index.php", [
                'error' => "404"
            ]);

        return $this->render(params: [
            'header_page' => 'admin',
            'countriesArray' => Country::getCountriesList(),
            'tourFacilities' => Facility::getFacilities("TourFacility"),
            'roomFacilities' => Facility::getFacilities("RoomFacility"),
            'toursArray' => Tour::getToursList(),
            'bookingArray' => Booking::getBookingArray(),
            'bookingHistory' => Booking::getBookingHistory(),
            'userArray' => User::getUserList()
        ]);
    }

    public function countryAction($params)
    {
        if (!User::isCurrentUserModerator())
            return $this->render("views/error/index.php", [
                'error' => "404"
            ]);

        if (Core::getInstance()->requestMethod == 'POST') {
            $ua_name = $_POST['ua_name'];
            $en_name = strtolower($_POST['en_name']);
            if (!isset($params[0])) {
                $flag = $_FILES['flag'];
                $pattern = $_FILES['pattern'];
                $video = $_FILES['video'];
                $cover = $_FILES['cover'];

                $cities = [];
                if (array_key_exists("city_name", $_POST)) {
                    for ($i = 0; $i < count($_POST['city_name']); $i++) {
                        $cities[] = [
                            'name' => $_POST['city_name'][$i],
                            'link' => $_POST['city_link'][$i],
                            'flag' => [
                                'type' => $_FILES['city_flag']['type'][$i],
                                'tmp_name' => $_FILES['city_flag']['tmp_name'][$i],
                            ]
                        ];
                    }
                }

                Country::addCountry($ua_name, $en_name, $flag, $pattern, $video, $cover, $cities);
                $this->message("Країну успішно додано", "positive");
            } else {
                $flag = $_FILES['flag']['name']? $_FILES['flag'] : null;
                $pattern = $_FILES['pattern']['name']? $_FILES['pattern'] : null;
                $video = $_FILES['video']['name']? $_FILES['video'] : null;
                $cover = $_FILES['cover']['name']? $_FILES['cover'] : null;

                $country_id = Country::getCountryByName($params[0])['country_id'];
                $cities = [
                    'edited' => [],
                    'new' => []
                ];
                if (array_key_exists("city_id", $_POST)) {
                    for ($i = 0; $i < count($_POST['city_id']); $i++) {
                        $cities['edited'][] = [
                            'city_id' => $_POST['city_id'][$i],
                            'name' => $_POST['city_name'][$i],
                            'link' => $_POST['city_link'][$i],
                            'flag' => $_FILES['city_flag']['tmp_name'][$i]? [
                                'type' => $_FILES['city_flag']['type'][$i],
                                'tmp_name' => $_FILES['city_flag']['tmp_name'][$i],
                            ] : null
                        ];
                    }
                }

                if (array_key_exists("city_name", $_POST))
                {
                    $i = array_key_exists("city_id", $_POST) ? count($_POST['city_id']) : 0;
                    for (; $i < count($_POST['city_name']); $i++)
                        $cities['new'][] = [
                            'name' => $_POST['city_name'][$i],
                            'link' => $_POST['city_link'][$i],
                            'flag' => [
                                'type' => $_FILES['city_flag']['type'][$i],
                                'tmp_name' => $_FILES['city_flag']['tmp_name'][$i],
                            ]
                        ];
                }

                Country::editCountry($country_id, $ua_name, $en_name, $flag, $pattern, $video, $cover, $cities);
                $this->message("Країну успішно змінено", "positive");
            }
            $this->redirect("/admin");
        } else if (Core::getInstance()->requestMethod == 'DELETE') {
            $_DELETE = json_decode(file_get_contents('php://input'), true);
            Country::deleteCountry($_DELETE['country_id']);
        } else {
            if (isset($params[0])) {
                return $this->render(path: 'views/admin/country_admin/country_editor/index.php', params: [
                    'country' => Country::getCountryByName($params[0]),
                    'header_page' => 'admin'
                ]);
            }
            else {
                return $this->render(path: 'views/admin/country_admin/country_editor/index.php', params: [
                    'header_page' => 'admin'
                ]);
            }
        }
    }
}