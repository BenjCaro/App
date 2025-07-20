<?php
namespace Carbe\App\Controllers;

class AddRecipe extends BaseController {
    
    public function index() {
         $this->render('Users/ajout-recette', [
            'title' => 'Petit Creux | Ajout de Recette'
         ]);
    }
}