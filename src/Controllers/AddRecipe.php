<?php
namespace Carbe\App\Controllers;

use Carbe\App\Models\CategoryModel;
use Carbe\App\Models\IngredientModel;

class AddRecipe extends BaseController {
    
    public function index() {

       $categories = $this->getCategories();
       $ingredients = $this->getIngredients();

        $this->render('Users/ajout-recette', [
            'title' => 'Petit Creux | Ajout de Recette',
            'categories' => $categories,
            'ingredients' => $ingredients
         ]);
    }

  private function getCategories() {
        
       $categoryModel = new CategoryModel($this->pdo);
       $categories = $categoryModel->findAll();
       return $categories;

  }

 private function getIngredients() {
      $ingredientModel = new IngredientModel($this->pdo);
      $ingredients = $ingredientModel->findAll();
      return $ingredients;
 }

 public function createRecipe(array $data) {
     session_start();

     $title = trim($data['title']);
     $idUser = $data['id_user'];
     $idCategory = $data['id_category'];
     $duration = trim($data['duration']);
     $description = trim($data['description']);

     $ingredients[] = $data['ingredients'];
     $quantity[] = $data['quantity'];
     $unit[] = $data['unit'];

     $errors = [];

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

     if(empty($ingredients || $quantity || $unit)) {
          $errors['ingredients[]'] = "Veuillez selectionner un ingrédient, sa quantité et l'unité.";
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

     $ingredientsData = [

     ];

 } 

   private function generateSlug(string $string) :string {

          $string = mb_strtolower($string);
          $string = preg_replace('/[^\w\s-]/', '', $string);
          $string = preg_replace('/[\s]+/', '-', $string);  
          $slug = trim($string, '-');
          return $slug;
   }

   private function descriptionInJson(string $steps) :string {

     $step = preg_split('/\r\n|\r|\n/', $steps);
     $step = array_map('trim', $step); 
     $step = array_filter($step);   

     return json_encode($step, JSON_UNESCAPED_UNICODE);

     }
}