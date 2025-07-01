<?php

namespace Carbe\App\Controllers;
use Carbe\App\Controllers\BaseController;
use Carbe\App\config\Database;



class HomeController extends BaseController {

    public function index() {

      $this->render('home');

    }
}