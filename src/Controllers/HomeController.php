<?php

namespace Carbe\App\Controllers;
use Carbe\App\Controllers\BaseController;
use Carbe\App\config\Database;
use Carbe\App\Models\UserModel;
use Carbe\App\Models\RecipeModel;
use Carbe\App\Models\CategoryModel;


class HomeController extends BaseController {

  // connexion database ;)


    public function index() :void {

     
      if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
      // affichage des favoris de l'utilisateur connecté

      $userModel = new UserModel($this->pdo);
      $auth_user = null;

      if (isset($_SESSION['auth_user']['id'])) {
        $auth_user = $userModel->findById($_SESSION['auth_user']['id']);
      } 
      $favoris = $auth_user ? $auth_user->getFavoris() : [];

      // affiche derniere recette ajouté

      $lastRecipe = (new RecipeModel($this->pdo))->newRecipe();
    ;
      // affiche les recettes avec le plus de favoris
      $popularRecipe = (new RecipeModel($this->pdo))->getMostPopularRecipe();
      
      // afficher les catégories findAll
      
      $category = new CategoryModel($this->pdo);
      $categories = $category->findAll();

      $this->render('home',  [
        'title' => 'Petit Creux',
        'auth_user' => $auth_user,
        'favoris' => $favoris,
        'lastRecipe' => $lastRecipe,
        'popularRecipe' => $popularRecipe,
        'categories' => $categories

      ]);

    }
}