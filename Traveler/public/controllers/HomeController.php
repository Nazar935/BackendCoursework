<?php

namespace controllers;

use models\Country;
use models\Post;
use models\User;

class HomeController extends \core\Controller
{
    public function indexAction()
    {
        /*$this->checkUser();*/


        return $this->render(params: [
            'countryArray' => Country::getCountriesList()
        ]);
    }

    /*public function jsonAction()
    {
        header('Content-type: application/json');
        $sliderArray = [];
        foreach (Country::getCountriesList() as $country)
            $sliderArray[] = [

            ]
    }*/
}