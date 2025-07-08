<?php

namespace Carbe\App\Controllers;
use Carbe\App\Controllers\BaseController;
use Carbe\App\Models\CategoryModel;
use Carbe\App\Models\RecipeModel;



class CategoryController extends BaseController {
     


public function index(): void
{
    $categoryModel = new CategoryModel($this->pdo);
    $categories = $categoryModel->findAll();

    $recipeModel = new RecipeModel($this->pdo);
    $recipesByCategory = [];

    foreach ($categories as $category) {
        $categoryId = $category->getId();
        $recipes = $recipeModel->getAllRecipesByCategory($categoryId);

        $recipesByCategory[] = [
            'category' => $category,
            'recipes' => $recipes
        ];
    }

    $this->render('Pages/categories', [
        'title' => 'Petit Creux | Catégories',
        'categories' => $categories,
        'recipesByCategory' => $recipesByCategory
    ]);
}

     public function displayRecipesByCat(string $slug) :void {

          $categoryModel = new CategoryModel($this->pdo);
          $category = $categoryModel->getCatBySlug($slug);
          
          $recipeModel = new RecipeModel($this->pdo);
          $recipes= $recipeModel->getAllRecipesByCategory($category['id']); // id dynamique des catégories

          $this->render('Pages/category', [
               'title' => 'Petit Creux | '  . ucfirst($category['name']),
               'recipes' => $recipes,
               'category' => $category

          ]);


     }
}