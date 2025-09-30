<?php 

namespace Carbe\App\Controllers\Admin;

use Carbe\App\Controllers\BaseController;
use Carbe\App\Services\Auth;

class AdminIngredientController extends BaseController {
      
    public function index() :void {

        Auth::isAdmin();

        $this->render('ingredients', [
                'title' => 'Petit Creux | Tout les ingrédients'
        ]);
    }   
}