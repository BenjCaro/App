<?php

namespace Carbe\App\Routes;
use Carbe\App\Controllers\HomeController;
use Carbe\App\Controllers\CategoryController;
use Carbe\App\Controllers\RecipeController;
use Carbe\App\Controllers\AboutController;
use Carbe\App\Controllers\AddRecipe;
use Carbe\App\Controllers\Admin\AdminController;
use Carbe\App\Controllers\Admin\DashboardController;
use Carbe\App\Controllers\Admin\ProfileUserController;
use Carbe\App\Controllers\AuthController;
use Carbe\App\Controllers\FavorisController;
use Carbe\App\Controllers\LoginController;
use Carbe\App\Controllers\PostController;
use Carbe\App\Controllers\SearchController;
use Carbe\App\Controllers\SigninController;
use Carbe\App\Controllers\UpdateRecipeController;
use Carbe\App\Controllers\UserController;
use Carbe\App\Models\UserModel;

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
    var_dump($_POST);
    $description = $_POST['description'];
    $user = new UserController();
    $user->updateDescription($id,
            ['_token' => $_POST['_token'],
             'description' => $description]);
            
});

$router->map('POST', '/mon-compte/suppr-favoris', function(){
    session_start();

    $idUser = $_SESSION['auth_user']['id'];
    $idRecipe = $_POST['favoris'];

    $favori = new FavorisController();
    $favori->delete($idUser, $idRecipe);
    
    
});

$router->map('POST', '/mon-compte/suppr-recette', function() {
    session_start();
    
    $idRecipe = $_POST['recipe'];

    $recipe = new RecipeController();
    $recipe->deleteRecipe($idRecipe);

    });

$router->map('GET', '/login', function() {
    $view = new LoginController();
    $view->displayLogin();
 });

$router->map('POST', '/login', function() {
    $token = $_POST['_token'];
    $email= $_POST['email']; 
    $password= $_POST['password'];
    $auth = new AuthController();
    $auth->login($token, $email, $password);
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


$router->map('GET', '/mes-commentaires/commentaire-[i:id]', function($id) {
        $post = new PostController();
        $post->showComment($id);
});

// route pour modifier le commentaire

$router->map('POST', '/mes-commentaires/commentaire-[*:id]', function($id) {
  

    $post = new PostController();
    $post->updateComment($id, $_POST);

});

// route pour suppr le commentaire


$router->map('POST', '/mes-commentaires/suppr/commentaire-[*:id]', function($id) {
  
    $post = new PostController();
    $post->deleteComment($id, $_POST);

});


// Route Administration 

$router->map('GET', '/admin', function() {
    $view = new DashboardController();
    $view->index();
});


$router->map('GET', '/admin/profil/utilisateur-[*:id]', function($id) {
    
    $view = new ProfileUserController();
    $view->index($id);

});

$router->map('POST', '/admin/profil/utilisateur-[*:id]/update-informations', function($id) {
   
    session_start();
    $update = new UserController();
    $update->updateInformations($id, $_POST);

});


$router->map('POST', '/admin/profil/utilisateur-[*:id]/update-description', function($id) {
     session_start();
     $description = new UserController();
     $description->updateDescription($id, $_POST);
});


$router->map('POST', '/admin/profil/utilisateur-[*:id]/update-role', function($id) {
    session_start();

    $role = new AdminController();
    $role->updateRole($id, $_POST['role']);
});

$router->map('POST', '/admin/profil/suppr-utilisateur-[*:id]', function($id) {
    
    session_start();
    $deleteUser = new AdminController();
    $deleteUser->deleteUser($id);

});