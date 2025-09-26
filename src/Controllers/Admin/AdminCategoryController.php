<?php

namespace Carbe\App\Controllers\Admin;

use Carbe\App\Controllers\BaseController;
use Carbe\App\Models\CategoryModel;
use Carbe\App\Models\RecipeModel;
use Carbe\App\Services\Auth;

/**
 * AdminCategoryController transmet les données liées aux catégories aux vues : 
 * Admin/category.php 
 * Admin/categories.php
 * 
 */

class AdminCategoryController extends BaseController {
     
    public function index() :void {

        Auth::isAdmin();
        
        $categoryModel = new CategoryModel($this->pdo);
        $categories= $categoryModel->countRecipesByCat();
        
        

          $this->render("categories", [
            'title' => 'Petit Creux | Catégories',
            'categories' => $categories
            
        ]);
    }


    public function displayRecipesByCat(string $slug) :void {

          Auth::isAdmin();

          $categoryModel = new CategoryModel($this->pdo);
          $category = $categoryModel->getCatBySlug($slug);
          
          $recipeModel = new RecipeModel($this->pdo);
          $recipes= $recipeModel->getAllRecipesByCategory($category->getId());

          $this->render('category', [
               'title' => 'Petit Creux | '  . ucfirst($category->getName()),
               'recipes' => $recipes,
               'category' => $category

          ]);


     }
}