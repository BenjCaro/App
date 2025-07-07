<?php

namespace Carbe\App\Controllers;
use Carbe\App\Controllers\BaseController;
use Carbe\App\config\Database;
use Carbe\App\Models\CategoryModel;
use Carbe\App\Models\RecipeModel;



class CategoryController extends BaseController {
     


     public function index() :void {
            
           
            // trouver toutes les catégories findALl

            $category = new CategoryModel($this->pdo);
            $categories = $category->findAll();

            // trouver toutes les recipes de chaque catégories 
            // SELECT * FROM `recipes`JOIN categories ON recipes.id_category = categories.id WHERE categories.id = :id

            $recipeModel = new RecipeModel($this->pdo);
            $recipes = $recipeModel->getAllRecipesWithCategory();

            $this->render('Pages/categories',  [
            'title' => 'Petit Creux | Catégories',
            'categories' => $categories,
            'recipes' => $recipes

        ]);
     } 

     public function displayRecipesByCat(string $slug) :void {

          $categoryModel = new CategoryModel($this->pdo);
          $category = $categoryModel->getCatBySlug($slug);
          
          $recipeModel = new RecipeModel($this->pdo);
          $recipes= $recipeModel->getAllRecipesByCategory($category['id']); // id dynamique des catégories

          $this->render('Pages/category', [
               'title' => 'Petit Creux | '  . ucfirst($category['name']),
               'recipes' => $recipes

          ]);


     }
}