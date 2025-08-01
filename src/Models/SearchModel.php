<?php

namespace Carbe\App\Models;
use PDO;
use Carbe\App\Models\RecipeModel;

class SearchModel extends BaseModel {
     
    public function getRecipeWithTitle(string $search) {

        $stmt = $this->pdo->prepare("SELECT recipes.title, recipes.slug, recipes.duration, categories.name AS category_name FROM recipes
            JOIN categories ON categories.id = recipes.id_category
            WHERE title LIKE :search ");
        $stmt->execute(['search' => "%$search%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $recipes = [];
        foreach($results as $data) {
            $recipe = new RecipeModel($this->pdo);
            $recipe->hydrate($data);
            $category = new CategoryModel($this->pdo);
            $category->hydrate(['name' =>$data['category_name']]);
            $recipe->setCategory($category);
            $recipes[] = $recipe;
        }

        return $recipes;
}}
