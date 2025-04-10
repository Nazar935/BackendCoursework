<?php

namespace controllers;

use core\Controller;

class ContactsController extends Controller
{
    public function indexAction()
    {
        return $this->render(params: [
            'header_page' => 'contacts'
        ]);
    }
}