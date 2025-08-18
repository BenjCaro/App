<?php
namespace Carbe\App\Controllers;
use Carbe\App\Models\RecipeModel;
use Carbe\App\Models\RecipeIngredientModel;
use Carbe\App\Models\CategoryModel;
use Carbe\App\Models\IngredientModel;
use function Carbe\App\Services\isAuth;
use Exception;


class UpdateRecipeController extends BaseController {

    public function index(string $slug) :void {

        isAuth();

        $recipeModel = new RecipeModel($this->pdo); 
        $recipe = $recipeModel->getRecipeBySlug($slug);
        $categories = $this->getCategories();
        $ingredients = $this->getIngredients(); 
       
        $this->render('Users/modif-recette',
        [
            'title' => 'Petit Creux | Modification de votre recette.',
            'recipe' => $recipe,
            'categories' => $categories,
            'ingredients' => $ingredients
        ]);
    }

/**
 * @param array<string, mixed> $data
 */


public function updateRecipe(int $id, array $data) :void {
        
        session_start();
        isAuth();

        $recipeModel = new RecipeModel($this->pdo);
        $recipe = $recipeModel->findById($id);

        if (!$recipe) {
            $_SESSION['flash'] = "Recette introuvable.";
            header('Location: /mes-recettes');
            exit;
        }

    // Vérifie que l'utilisateur connecté est bien le propriétaire
        $this->checkUser($recipe->getIdUser());
      
 
        $id = $data['id'];
        // $duration = trim($data['duration']);
        $description = $data['description'] ?? null;
        $duration = $data['duration'];
        $ingredients = $data['ingredients'];
        $quantity= $data['quantites'];
        $unit = $data['unit'];
        
          if (!empty($description)) {
        $description = $this->descriptionInJson($description);
        } else {
        $description = null; 
    }

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

    public function deleteIngredient(int $id, string $slug) :void {
        
        session_start();
        isAuth();
        $recipeModel = new RecipeModel($this->pdo);
        $recipe = $recipeModel->findById($id);

        if (!$recipe) {
            $_SESSION['flash'] = "Recette introuvable.";
            header('Location: /mes-recettes');
            exit;
        }

        $this->checkUser($recipe->getIdUser());
     

         $ingredient = new RecipeIngredientModel($this->pdo);
         $ingredient->removeIngredient($id);

         $recipe = new RecipeModel($this->pdo);
         $recipe->getRecipeBySlug($slug);
         $_SESSION['flash']= "Ingrédient retiré avec succes!";
         header("Location: /update/recette/$slug");

    }


/**
 * Convertit les étapes des recettes en JSON.
 *
 * @param string|string[] $steps
 */

private function descriptionInJson(string|array $steps) :string {

     
     $steps = array_map('trim', $steps); 
     $steps = array_filter($steps);   

     return json_encode($steps, JSON_UNESCAPED_UNICODE);

     }


/**
 * 
 * @return CategoryModel[]
 * 
 */
private function getCategories() :array {
        
       $categoryModel = new CategoryModel($this->pdo);
       $categories = $categoryModel->findAll();
       return $categories;

  }

  /**
 * 
 * @return IngredientModel[]
 * 
 */

 private function getIngredients() :array {
      $ingredientModel = new IngredientModel($this->pdo);
      $ingredients = $ingredientModel->findAll();
      return $ingredients;
 }
}