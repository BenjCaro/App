<?php

namespace Carbe\App\Controllers;
use Carbe\App\Controllers\BaseController;
use Carbe\App\config\Database;
use Carbe\App\Models\UserModel;
use Carbe\App\Models\RecipeModel;
use Carbe\App\Models\CategoryModel;


class HomeController extends BaseController {

  // connexion database ;)


    public function index() {

      $bdd = new Database();
      $pdo = $bdd->connectDB();

      // affichage des favoris de l'utilisateur connecté

      $userModel = new UserModel($pdo);
      $user = $userModel->findById(1);  
      $favoris = $user ? $user->getFavoris() : [];

      // affiche derniere recette ajouté

      $lastRecipe = (new RecipeModel($pdo))->newRecipe();
    ;
      // affiche les recettes avec le plus de favoris
      $popularRecipe = (new RecipeModel($pdo))->getMostPopularRecipe();
      
      // afficher les catégories findAll
      
      $category = new CategoryModel($pdo);
      $categories = $category->findAll();

      $this->render('home',  [
        'title' => 'Petit Creux',
        'user' => $user,
        'favoris' => $favoris,
        'lastRecipe' => $lastRecipe,
        'popularRecipe' => $popularRecipe,
        'categories' => $categories

      ]);

    }
}