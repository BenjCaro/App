<?php
namespace Carbe\App\Controllers;

use Carbe\App\Models\CategoryModel;
use Carbe\App\Models\IngredientModel;
use Carbe\App\Models\RecipeIngredientModel;
use Carbe\App\Models\RecipeModel;
use Carbe\App\Services\Auth;
use Carbe\App\Services\Flash;
use Carbe\App\Services\Csrf;

use Exception;
class AddRecipe extends BaseController {
    
    public function index() :void {

     Auth::isAuth();

       $categories = $this->getCategories();
       $ingredients = $this->getIngredients();

        $this->render('Users/ajout-recette', [
            'title' => 'Petit Creux | Ajout de Recette',
            'categories' => $categories,
            'ingredients' => $ingredients
         ]);
    }

 /**
  * @return CategoryModel[]
  *
  */

  private function getCategories() {
        
       $categoryModel = new CategoryModel($this->pdo);
       $categories = $categoryModel->findAll();
       return $categories;

  }

 /**
  * @return IngredientModel[]
  *
  */
 private function getIngredients() {
      $ingredientModel = new IngredientModel($this->pdo);
      $ingredients = $ingredientModel->findAll();
      return $ingredients;
 }


/**
 * createRecipe() permet de créer une recette 
 * et de l'inscrire en base dans deux tables :
 *  - recipes
 *  - recipes_ingredients
 * 
 * @param array<string, mixed> $data
 */

 public function createRecipe(array $data) :void {
     session_start();

     Auth::isAuth();

     $token = $data['_token'];
     $title = trim($data['title']);
     $idUser = $data['id_user'];
     $idCategory = $data['id_category'];
     $duration = trim($data['duration']);
     $description = trim($data['description']);

     $ingredients = $data['ingredients'];
     $quantity= $data['quantites'];
     $unit = $data['unit'];

     $errors = [];

     Csrf::check("add_recipe", $token, "/mon-compte");

     if(empty($title)) {
          $errors['title'] = "Veuillez donner un titre à la recette.";
     }

     if(empty($idUser)) {
          $errors['id_user'] = 'Veuillez vous reconnecter à votre compte.';
     }

     if(empty($idCategory)) {
          $errors['id_category'] = 'Sélectionner une catégorie pour votre recette.';
     }

     if(empty($duration)) {
          $errors['duration']= "Veuillez préciser une durée de préparation pour votre recette.";
     }

     if(empty($description)) {
          $errors['description'] = "Veuillez rédiger les étapes de préparation de votre recette.";
     }

     if(empty($ingredients) || empty($quantity) || empty($unit)) {
          $errors['ingredients'] = "Veuillez selectionner un ingrédient, sa quantité et l'unité.";
     }

     if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /ajout-recette');
            exit;
     }

     $slug = $this->generateSlug($title);
     $description = $this->descriptionInJson($description);

     $recipeData = [
          'title' => $title,
          'slug' => $slug, 
          'id_user' => $idUser,
          'id_category' => $idCategory,
          'duration' => $duration,
          'description' => $description
     ];

     try {
     $this->pdo->beginTransaction();
     $recipe = new RecipeModel($this->pdo);
     $recipe->insert($recipeData);
     $recipeId = $this->pdo->lastInsertId();

     $recipeIngredientModel = new RecipeIngredientModel($this->pdo);

     foreach ($ingredients as $i => $ingredient) {
          $recipeIngredientModel->insert(
                [
               'id_recipe' => $recipeId ,
               'id_ingredient' => $ingredient ,
               'quantity' => $quantity[$i],
               'unit' => $unit[$i]
          ]
          );
     }
     
          $this->pdo->commit();
          Flash::set("Création de la recette " . $title . " réussie!", "primary");
          header('Location: /');
          exit;

     } catch(Exception $e) {

          $this->pdo->rollBack();
          $_SESSION['errors']['database'] = "Erreur dans la soumission du formulaire.";
          header('Location: /ajout-recette');
          exit;
     }
 } 

 /**
  * A partir du titre de la recette donné par l'utilisateur 
  * cette methode permet de créer le slug 
  */

   private function generateSlug(string $string) :string {

          $string = mb_strtolower($string);
          $string = preg_replace('/[^\w\s-]/', '', $string);
          $string = preg_replace('/[\s]+/', '-', $string);  
          $slug = trim($string, '-');
          return $slug;
   }


   /**
    * Cette methode permet de convertir en json la description de la recette 
    * avant l'inscription en base de données
    */

   private function descriptionInJson(string $steps) :string {

     $step = preg_split('/\r\n|\r|\n/', $steps);
     $step = array_map('trim', $step); 
     $step = array_filter($step);   

     return json_encode($step, JSON_UNESCAPED_UNICODE);

     }
}