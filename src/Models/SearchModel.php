<?php

namespace Carbe\App\Models;
use PDO;
use Carbe\App\Models\RecipeModel;

class SearchModel extends BaseModel {
     
/**
* Recherche des recettes par titre.
*
* @param string $search
* @return array{recipes: RecipeModel[], totalResults: int}
*/

    public function getRecipeWithTitle(string $search) :array {

        $stmt = $this->pdo->prepare("SELECT 
            recipes.title, 
            recipes.slug, 
            recipes.duration, 
            categories.name AS category_name,
            COUNT(*) OVER() AS total_results
            FROM recipes
            JOIN categories ON categories.id = recipes.id_category
            WHERE recipes.title LIKE :search;
        ");
        $stmt->execute(['search' => "%$search%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalResults = $results ? (int)$results[0]['total_results'] : 0;

        $recipes = [];
        foreach($results as $data) {
            $recipe = new RecipeModel($this->pdo);
            $recipe->hydrate($data);
            $category = new CategoryModel($this->pdo);
            $category->hydrate(['name' =>$data['category_name']]);
            $recipe->setCategory($category);
            $recipes[] = $recipe;
        }

        return [
        'recipes' => $recipes,
        'totalResults' => $totalResults
    ];
}}
