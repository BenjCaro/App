<?php

namespace Carbe\App\Controllers;
use Carbe\App\config\Database;
use Carbe\App\Models\RecipeModel;

class HomeController {


    public function index() {
    $connectDB = new Database();
    $pdo = $connectDB->connectDB(); 

   $recipe = new RecipeModel($pdo);
$recipe->setId(1);
$recipe->getRecipe(); // hydrate + crée les ingrédients

// Affiche les infos de la recette
echo "Titre : " . $recipe->getTitle() . "<br>";
echo "Durée : " . $recipe->getDuration() . " minutes<br>";
echo "Description : " . $recipe->getDescription() . "<br>";

// Affiche les ingrédients
echo "<h3>Ingrédients :</h3>";
foreach ($recipe->getIngredients() as $recipeIngredient) {
    $ingredient = $recipeIngredient->getIngredient(); // instance de IngredientModel
    echo "- " . $ingredient->getName() . " (" . $ingredient->getType() . ") : "
         . $recipeIngredient->getQuantity() . " " . $recipeIngredient->getUnit() . "<br>";
}

}
    
}
