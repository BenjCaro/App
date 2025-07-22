<?php
namespace Carbe\App\Controllers;
use Carbe\App\Models\RecipeModel;

class UpdateRecipeController extends BaseController {

    public function index(string $slug) :void {

        $recipeModel = new RecipeModel($this->pdo); 
        $recipe = $recipeModel->getRecipeBySlug($slug);
       
        $this->render('Users/modif-recette',
        [
            'title' => 'Petit Creux | Modification de votre recette.',
            'recipe' => $recipe
        ]);
    }
}