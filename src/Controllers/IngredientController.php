<?php

namespace Carbe\App\Controllers;
use Carbe\App\Models\IngredientModel;

class IngredientController extends BaseController {
     
    public function removeIngredient(int $id) {
            session_start();

            $ingredient = new IngredientModel($this->pdo);
            $ingredient->delete($id);
            $_SESSION['flash'] = "Ingrédient retiré.";

     }
}