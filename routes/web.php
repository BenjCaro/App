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
use Carbe\App\Controllers\PostController;
use Carbe\App\Controllers\SearchController;
use Carbe\App\Controllers\SigninController;
use Carbe\App\Controllers\UpdateRecipeController;
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
   
     $recipe = new RecipeController();
     $recipe->displayRecipe($slug);

});

$router->map('POST', '/recette/[*:slug]/favoris', function($slug) {    
    $idUser = $_POST['user'];
    $idRecipe = $_POST['recipe'];
  
    $favori = new FavorisController();
    $favori->insert($idUser, $idRecipe);

    header("Location: /recette/" . $slug);
    exit();
});

$router->map('POST', '/recette/[*:slug]/commentaires', function($slug) {    
     
    $post = new PostController();
    $post->addComments($slug, $_POST);

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

$router->map('POST', '/mon-compte/update-profil', function() {
    session_start();
    $id = $_SESSION['auth_user']['id'];

    $data = $_POST;
    $user = new UserController();
    $user->updateInformations($id, $data);

});


$router->map('POST', '/mon-compte/update-description', function() {
    
    session_start();
    $id = $_SESSION['auth_user']['id'];
    
    $description = $_POST['description'];
    var_dump($description);
    $user = new UserController();
    $user->updateDescription($id, 
            ['description' => $description]);
            
});

$router->map('POST', '/mon-compte/suppr-favoris', function(){
    session_start();

    $idUser = $_SESSION['auth_user']['id'];
    $idRecipe = $_POST['favoris'];

    $favori = new FavorisController();
    $favori->delete($idUser, $idRecipe);
    
    header('Location: /mon-compte');
    exit();
});

$router->map('POST', '/mon-compte/suppr-recette', function() {
    session_start();
    
    $idRecipe = $_POST['recipe'];

    $recipe = new RecipeController();
    $recipe->deleteRecipe($idRecipe);

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

$router->map('POST', '/ajout-recette', function(){

    $recipe = new AddRecipe();
    $recipe->createRecipe($_POST);
    header('Location: /');
    
});

$router->map('GET', '/update/recette/[*:slug]', function($slug) {
    
    $view = new UpdateRecipeController();
    $view->index($slug);
});

$router->map('POST', '/update/recette', function() {
  
    $id = $_POST['id'];

    $recipe = new UpdateRecipeController();
    $recipe->updateRecipe($id, $_POST);

});

$router->map('GET', '/suppr-ingredient/[*:id]-[*:slug]', function($id, $slug) {

   $ingredient = new UpdateRecipeController();
   $ingredient->deleteIngredient($id,$slug);

});


$router->map('GET', '/search', function(){

    $search = new SearchController();
    $search->query();

});


$router->map('GET', '/mes-commentaires/commentaire-[*:id]', function($id) {
        $post = new PostController();
        $post->showComment($id);
});

