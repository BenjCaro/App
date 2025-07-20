<?php

namespace Carbe\App\Routes;
use Carbe\App\Controllers\HomeController;
use Carbe\App\Controllers\CategoryController;
use Carbe\App\Controllers\RecipeController;
use Carbe\App\Controllers\AboutController;
use Carbe\App\Controllers\AddRecipe;
use Carbe\App\Controllers\AuthController;
use Carbe\App\Controllers\FavorisController;
use Carbe\App\Controllers\LoginController;
use Carbe\App\Controllers\SigninController;
use Carbe\App\Controllers\UserController;


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

$router->map('POST', '/recette/[*:slug]', function($slug) {    
    $idUser = $_POST['user'];
    $idRecipe = $_POST['recipe'];
  
    $favori = new FavorisController();
    $favori->insert($idUser, $idRecipe);

    header("Location: /recette/" . $slug);
    exit();
});

$router->map('GET', '/a-propos', function() {
       $about = new AboutController();
       $about->displayAbout();
 });

$router->map('GET', '/mon-compte', function() {
     $user = new UserController();
     $user->getMyProfil();
 });

$router->map('POST', '/mon-compte', function(){
    session_start();

    $idUser = $_SESSION['auth_user']['id'];
    $idRecipe = $_POST['recipe'];

    $favori = new FavorisController();
    $favori->delete($idUser, $idRecipe);
    

    header('Location: /mon-compte');
    exit();
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

$router->map('GET', '/inscription', function(){
     $view = new SigninController();
     $view->index();
});


$router->map('POST', '/inscription', function() {


    $user = new UserController();
    $user->createUser($_POST);
         
});

$router->map('GET', '/logout', function() {
    require('../src/Views/Users/logout.php');
});

$router->map('GET', '/ajout-recette', function() {

    $view = new AddRecipe();
    $view->index();

});