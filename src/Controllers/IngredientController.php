<?php

namespace Carbe\App\Controllers;
use Carbe\App\Models\IngredientModel;
use Carbe\App\Services\Flash;

class IngredientController extends BaseController {
     
    public function removeIngredient(int $id) :void {
            session_start();

            $ingredient = new IngredientModel($this->pdo);
            $ingredient->delete($id); 
            
            Flash::set("Ingrédient retiré.", "primary");
     }
}