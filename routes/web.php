<?php

namespace Carbe\App\Routes;
use Carbe\App\Controllers\HomeController;

$router->map('GET', '/', function() {
    
    $home = new HomeController();
    $home->index();

});

// $router->map('GET', '/categories', function() {
//    
//     
//
//
//});