<?php

namespace Carbe\App\Controllers\Admin;

use Carbe\App\Controllers\BaseController;
use Carbe\App\Models\CategoryModel;

class AllCategoriesController extends BaseController {
     
    public function index() :void {
        
        $categoryModel = new CategoryModel($this->pdo);
        $categories= $categoryModel->countRecipesByCat();
        
        

          $this->render("categories", [
            'title' => 'Petit Creux | Catégories',
            'categories' => $categories
            
        ]);
    }
}