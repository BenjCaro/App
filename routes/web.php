<?php

namespace Carbe\App\Routes;
use Carbe\App\Controllers\HomeController;
use Carbe\App\Controllers\CategoryController;

$router->map('GET', '/', function() {
    
    $home = new HomeController();
    $home->index();

});

$router->map('GET', '/categories', function() {
   
    $categories = new CategoryController();
    $categories->index();


});