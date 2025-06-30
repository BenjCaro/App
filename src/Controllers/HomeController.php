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
    $result = $recipe->getRecipe();

    
    var_dump($result);               
}
    
}
