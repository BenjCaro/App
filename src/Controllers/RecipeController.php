<?php
namespace Carbe\App\Controllers;

use Carbe\App\Models\PostModel;
use Carbe\App\Models\RecipeModel;

use function Carbe\App\Services\isAuth;
use Carbe\App\Services\Flash;

class RecipeController extends BaseController {
     
    
        public function displayRecipe(string $slug) :void {

            $recipeModel = new RecipeModel($this->pdo); 
            $recipe = $recipeModel->getRecipeBySlug($slug);

            if ($recipe === null) {

                
                Flash::set("La recette n'existe pas", "secondary");
                header('Location: /home');
                exit;

            } 
                
                $id = $recipe->getId();
                $postModel = new PostModel($this->pdo);
                $posts = $postModel->showApprovedComments($id);

                $this->render('Pages/recette',[
                    'title' => 'Petit Creux | ' . ucfirst($recipe->getTitle()),
                    'recipe' => $recipe,
                    'posts' => $posts
                ]); 

            

      }

      public function deleteRecipe(int $idRecipe) :void {

        session_start();
        isAuth();
        $recipe = new RecipeModel($this->pdo);
        $recipe->findById($idRecipe);

        $this->checkUser($recipe->getIdUser());

        $recipeModel = new RecipeModel($this->pdo);
        $recipeModel->delete($idRecipe);

        
        Flash::set("Recette Supprimée", "primary");
        header('Location: /mon-compte');
        exit();
      }
}