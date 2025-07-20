<?php
namespace Carbe\App\Controllers;

use Carbe\App\Models\CategoryModel;
use Carbe\App\Models\IngredientModel;

class AddRecipe extends BaseController {
    
    public function index() {

       $categories = $this->getCategories();
       $ingredients = $this->getIngredients();

        $this->render('Users/ajout-recette', [
            'title' => 'Petit Creux | Ajout de Recette',
             'categories' => $categories,
             'ingredients' => $ingredients
         ]);
    }

  private function getCategories() {
        
       $categoryModel = new CategoryModel($this->pdo);
       $categories = $categoryModel->findAll();
       return $categories;

  }

 private function getIngredients() {
      $ingredientModel = new IngredientModel($this->pdo);
      $ingredients = $ingredientModel->findAll();
      return $ingredients;
 }

}