<?php
namespace Carbe\App\Controllers;
use Carbe\App\Models\RecipeModel;

class RecipeController extends BaseController {
     
    
        public function displayRecipe(string $slug) {

            $recipeModel = new RecipeModel($this->pdo); 
            $recipe = $recipeModel->getRecipeBySlug($slug);

            $this->render('Pages/recette',[
                'title' => 'Petit Creux | ' . ucfirst($recipe->getTitle()),
                'recipe' => $recipe
            ]); 



      }
}