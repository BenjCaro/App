<?php 

namespace Carbe\App\Controllers\Admin;

use Carbe\App\Controllers\BaseController;
use Carbe\App\Services\Auth;
use Carbe\App\Models\IngredientModel;

class AdminIngredientController extends BaseController {
      
    public function index() :void {

        Auth::isAdmin();

        $ingredientModel = new IngredientModel($this->pdo);
        $ingredients = $ingredientModel->findAll();

        $this->render('ingredients', [
                'title' => 'Petit Creux | Tout les ingrédients',
                'ingredients' => $ingredients
        ]);
    }   
}