<?php
namespace Carbe\App\Controllers;
use Carbe\App\Models\RecipeModel;
use Carbe\App\Models\RecipeIngredientModel;
use Exception;


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

    public function updateRecipe(int $id, array $data) {
        
        session_start();

        $id = $data['id'];
        // $duration = trim($data['duration']);
        $description = $data['description'];
        $duration = $data['duration'];
        $ingredients = $data['ingredients'];
        $quantity= $data['quantites'];
        $unit = $data['unit'];
        
        $description = $this->descriptionInJson($description);

        try {
            $this->pdo->beginTransaction();
            $recipe = new RecipeModel($this->pdo);
            $recipe->update($id, [
                'duration' => $duration,
                'description' => $description
        ]);

        $recipeIngredientModel = new RecipeIngredientModel($this->pdo);
        $recipeIngredientModel->deleteByRecipeId($id);

    
        foreach ($ingredients as $i => $ingredient) {
          $recipeIngredientModel->insert(
                [
               'id_recipe' => $id,
               'id_ingredient' => $ingredient ,
               'quantity' => $quantity[$i],
               'unit' => $unit[$i]
            ]
          );
        }

         $this->pdo->commit();
         $_SESSION['flash'] = "Mise à jour de la recette réussie!";
         header('Location: /mon-compte');

        } catch(Exception $e) {
            $this->pdo->rollBack();
            $_SESSION['errors']['database'] = "Erreur dans la soumission du formulaire." . $e->getMessage();
            header('Location: /mon-compte');
            exit;
        }
        
    }

    private function descriptionInJson(string|array $steps) :?string {

     
     $steps = array_map('trim', $steps); 
     $steps = array_filter($steps);   

     return json_encode($steps, JSON_UNESCAPED_UNICODE);

     }
}