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
      $category = new CategoryController();
      $category->displayRecipesByCat($slug);
}); 

$router->map('GET', '/recette/[*:slug]', function($slug) {    // page recette ex: recette/crepes 
    // instancier RecipeModel()
    // recuperer le slug pour recuperer la recette via l'id
 });

 $router->map('GET', '/a-propos', function() {
   echo("A propos");
 });

  $router->map('GET', '/mon-compte', function() {
   echo("Mon Compte");
 });

  $router->map('GET', '/login', function() {
   echo("Login");
 });