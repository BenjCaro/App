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
        $description = trim($data['description']);

        $ingredients = $data['ingredients'];
        $quantity= $data['quantites'];
        $unit = $data['unit'];
                

        try {
            $this->pdo->beginTransaction();
            $recipe = new RecipeModel($this->pdo);
            $recipe->update($id, [
                'description' => $description
        ]);

        $recipeIngredientModel = new RecipeIngredientModel($this->pdo);

        foreach ($ingredients as $i => $ingredient) {
          $recipeIngredientModel->insert(
                [
               
               'id_ingredient' => $ingredient ,
               'quantity' => $quantity[$i],
               'unit' => $unit[$i]
            ]
          );

          $this->pdo->commit();
          $_SESSION['flash'] = "Mise à jour de la recette réussie!";
          header('Location: /mon-compte');
        }

        } catch(Exception $e) {
            $this->pdo->rollBack();
            $_SESSION['errors']['database'] = "Erreur dans la soumission du formulaire.";
            header('Location: /ajout-recette');
            exit;
        }
        




    }
}