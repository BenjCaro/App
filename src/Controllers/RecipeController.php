<?php
namespace Carbe\App\Controllers;

use Carbe\App\Models\PostModel;
use Carbe\App\Models\RecipeModel;

class RecipeController extends BaseController {
     
    
        public function displayRecipe(string $slug) :void {

            $recipeModel = new RecipeModel($this->pdo); 
            $recipe = $recipeModel->getRecipeBySlug($slug);
            $postModel = new PostModel($this->pdo);
            $posts = $postModel->showComments();

            $this->render('Pages/recette',[
                'title' => 'Petit Creux | ' . ucfirst($recipe->getTitle()),
                'recipe' => $recipe,
                'posts' => $posts
            ]); 

      }

      public function deleteRecipe(int $idRecipe) :void {

         $recipeModel = new RecipeModel($this->pdo);
         $recipeModel->setId($idRecipe);
         $recipeModel->delete();

         $_SESSION['flash'] = "Recette supprimée.";

      }
}