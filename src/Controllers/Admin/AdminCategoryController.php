<?php

namespace Carbe\App\Controllers\Admin;

use Carbe\App\Controllers\BaseController;
use Carbe\App\Models\CategoryModel;
use Carbe\App\Models\RecipeModel;
use Carbe\App\Services\Auth;

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
          $recipes= $recipeModel->getAllRecipesByCategory($category['id']);

          $this->render('category', [
               'title' => 'Petit Creux | '  . ucfirst($category['name']),
               'recipes' => $recipes,
               'category' => $category

          ]);


     }
}