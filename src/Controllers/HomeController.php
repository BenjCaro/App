<?php

namespace Carbe\App\Controllers;
use Carbe\App\config\Database;

class HomeController {


    public function index() {

        $connectDB = new Database();
        $connectDB->connectDB();

        echo('Petit Creux');
    } 

}
