<?php

namespace controllers;

use core\Controller;

class TestController extends Controller
{
    public function indexAction()
    {
        return $this->render();
    }
}