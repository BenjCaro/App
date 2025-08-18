<?php

namespace Carbe\App\Controllers;
use Carbe\App\Models\IngredientModel;

class IngredientController extends BaseController {
     
    public function removeIngredient(int $id) :void {
            session_start();

            $ingredient = new IngredientModel($this->pdo);
            $ingredient->delete($id); // warning PhpStan car delete() n'a pas d'argument dans BaseModel
            $_SESSION['flash'] = "Ingrédient retiré.";

     }
}