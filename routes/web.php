<?php

namespace Carbe\App\Routes;
use Carbe\App\Controllers\HomeController;
use Carbe\App\Controllers\CategoryController;

$router->map('GET', '/', function() {
    
    $home = new HomeController();
    $home->index();

});

$router->map('GET', '/categories', function() {  // toutes les catégories listées
   
    $categories = new CategoryController();
    $categories->index();


});



 $router->map('GET', '/categories/[*:slug]', function($slug) {    // page catégories ex: categories/dessert 
      echo "Catégorie : " . htmlspecialchars($slug);
}); 


 $router->map('GET', '/recette/[*:slug]', function($slug) {    // page recette ex: recette/crepes 
  echo "Recette : " . htmlspecialchars($slug);
 });

