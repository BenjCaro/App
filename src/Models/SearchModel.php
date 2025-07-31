<?php

namespace Carbe\App\Models;
use PDO;
use Carbe\App\Models\RecipeModel;

class SearchModel extends BaseModel {
     
    public function getRecipeWithTitle(string $search) {

        $stmt = $this->pdo->prepare("SELECT recipes.title, recipes.slug FROM recipes WHERE title LIKE :search ");
        $stmt->execute(['search' => "%$search%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
}}
