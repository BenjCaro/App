<?php

namespace Carbe\App\Routes;
use Carbe\App\Controllers\HomeController;
use Carbe\App\Controllers\CategoryController;
use Carbe\App\Controllers\RecipeController;
use Carbe\App\Controllers\AboutController;
use Carbe\App\Controllers\AuthController;
use Carbe\App\Controllers\LoginController;

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
     $recipe = new RecipeController();
     $recipe->displayRecipe($slug);

    // recuperer le slug pour recuperer la recette via l'id
});

$router->map('GET', '/a-propos', function() {
       $about = new AboutController();
       $about->displayAbout();
 });

$router->map('GET', '/mon-compte', function() {
   echo("Mon Compte");
 });

$router->map('GET', '/login', function() {
    $view = new LoginController();
    $view->displayLogin();
 });

$router->map('POST', '/login', function() {
        $email= $_POST['email']; 
        $password= $_POST['password'];
        $auth = new AuthController();
        $auth->login($email, $password);
});