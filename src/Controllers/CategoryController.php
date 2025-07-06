<?php

namespace Carbe\App\Controllers;
use Carbe\App\Controllers\BaseController;
use Carbe\App\config\Database;
use Carbe\App\Models\CategoryModel;
use Carbe\App\Models\RecipeModel;



class CategoryController extends BaseController {
     // trouver toutes les catégories findALl
     // trouver toutes les recipes de chaque catégories 

     public function index() {
            
            $bdd = new Database();
            $pdo = $bdd->connectDB();

            // trouver toutes les catégories findALl

            $category = new CategoryModel($pdo);
            $categories = $category->findAll();

            // trouver toutes les recipes de chaque catégories 
            // SELECT * FROM `recipes`JOIN categories ON recipes.id_category = categories.id WHERE categories.id = :id

            $recipeModel = new RecipeModel($pdo);
            $recipes = $recipeModel->getAllRecipesByCategory();

            $this->render('categories',  [
            'title' => 'Petit Creux | Catégories',
            'categories' => $categories,
            'recipes' => $recipes

        ]);
     } 
}