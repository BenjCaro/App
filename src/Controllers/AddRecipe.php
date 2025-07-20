<?php
namespace Carbe\App\Controllers;

use Carbe\App\Models\CategoryModel;

class AddRecipe extends BaseController {
    
    public function index() {

       $categories = $this->getCategories();

        $this->render('Users/ajout-recette', [
            'title' => 'Petit Creux | Ajout de Recette',
             'categories' => $categories
         ]);
    }

  private function getCategories() {
        
       $categoryModel = new CategoryModel($this->pdo);
       $categories = $categoryModel->findAll();
       return $categories;


  }
}