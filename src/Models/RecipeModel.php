<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use Carbe\App\Models\IngredientModel;
use Carbe\App\Models\RecipeIngredientModel;
use Carbe\App\Models\CategoryModel;

use PDO;
use Exception;


class RecipeModel extends BaseModel {

   protected string $table = 'recipes';

  /** @var RecipeIngredientModel[] $ingredients */

    private array $ingredients = [];
    private string $title;
    private string $slug;
    private int $idUser;
    private int $idCategory;
    private string $createdAt;
    private int $duration;
    private ?string $description;
    private CategoryModel $category;

/**
* @param array <string, mixed> $data
*/

public function __construct(PDO $pdo, array $data = [])
    {
        parent::__construct($pdo);
       
      if (!empty($data)) {
            $this->hydrate($data);
      }
    }

public function getTitle() :string {
        return $this->title;
   }

   public function setTitle(string $title) :void {
    $this->title = $title;
   }

   public function getSlug() : string {
     return $this->slug;
  }

  public function setSlug(string $slug) : void {
     $this->slug = $slug;
  }

  public function getIdUser(): int {
    return $this->idUser;
}

public function setIdUser(int $idUser): void {
    $this->idUser = $idUser;
}

public function getIdCategory(): int {
    return $this->idCategory;
}

public function setIdCategory(int $idCategory): void {
    $this->idCategory = $idCategory;
}


public function getCreatedAt() :string {
    return $this->createdAt;
  }

public function setCreatedAt(string $createdAt) : void {
   $this->createdAt = $createdAt;
  }

public function getDuration() :int {
     return $this->duration;

  }

public function setDuration(int $duration) :void {
     $this->duration = $duration;
  }

public function getDescription() :string {
     return $this->description;
  }

public function setDescription(?string $description) :void {
    $this->description = $description;
  }

/** @return RecipeIngredientModel[] $ingredients */

  public function getIngredients(): array {
      return $this->ingredients;
}  
/** @param RecipeIngredientModel[] $ingredients */
public function setIngredients(array $ingredients) :void {

    $this->ingredients = $ingredients;
    
 }
public function getCategory(): CategoryModel {
    return $this->category;
}

public function setCategory(CategoryModel $category):void {
  $this->category = $category;
}


/**
 * @throws \Exception Si aucune recette n'est trouvée pour le slug donné
 * @return RecipeModel
 */

public function getRecipeBySlug(string $slug) :RecipeModel {  
    $stmt = $this->pdo->prepare('SELECT
     recipes.id AS recipe_id, 
     recipes.title, 
     recipes.duration, 
     recipes.description,
     ingredients.name,
     recipes_ingredients.quantity,
     recipes_ingredients.unit
    FROM recipes 
    JOIN recipes_ingredients ON recipes.id = recipes_ingredients.id_recipe
    JOIN ingredients ON ingredients.id = recipes_ingredients.id_ingredient
    WHERE recipes.slug = :slug');
    $stmt->execute([
       'slug' => $slug
    ]);
   $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
   if (!$data) {
        throw new \Exception("Aucune recette trouvée pour le slug : $slug");
    }

    
    $recipe = new RecipeModel($this->pdo);
    $recipe->hydrate([
        'id' => $data[0]['recipe_id'],
        'title' => $data[0]['title'],
        'duration' => $data[0]['duration'],
        'description' => $data[0]['description'],

    ]);

    
    $ingredients = [];
    foreach ($data as $row) {
        $ingredient = new IngredientModel($this->pdo);
        $ingredient->hydrate(['name' => $row['name']]);

        $recipeIngredient = new RecipeIngredientModel($this->pdo);
        $recipeIngredient->hydrate([
            'quantity' => $row['quantity'],
            'unit' => $row['unit']
        ]);
        $recipeIngredient->setIngredient($ingredient);

        $ingredients[] = $recipeIngredient;
    }

    $recipe->setIngredients($ingredients);

    return $recipe;
}

public function newRecipe() :RecipeModel {
      $stmt = $this->pdo->prepare("
      SELECT 
         recipes.id, 
         recipes.title, 
         recipes.slug AS recipe_slug, 
         recipes.createdAt, recipes.duration, 
         recipes.description, 
         categories.id AS category_id, 
         categories.name AS category_name, 
         categories.slug AS category_slug 
      FROM recipes 
      JOIN categories ON id_category = categories.id 
      ORDER BY createdAt
      DESC LIMIT 1;");

      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if (!$data) {
        throw new \Exception("Aucune recette trouvée");
    }
      
         $categoryData = [
        'id' => $data['category_id'],
        'name' => $data['category_name'],
        'slug' => $data['category_slug']
    ];

         $category = new CategoryModel($this->pdo);
         $category->hydrate($categoryData);
    
         $this->hydrate([
            'id' => $data['id'],
            'title' => $data['title'],
            'slug' => $data['recipe_slug'],
            'createdAt' => $data['createdAt'],
            'duration' => $data['duration'],
            'description' => $data['description']
        ]);
         $this->setCategory($category);

         return $this;

   }

public function getMostPopularRecipe() :?RecipeModel {
    $stmt = $this->pdo->prepare("
        SELECT 
            recipes.id AS recipe_id,
            recipes.title AS recipe_title,
            recipes.slug AS recipe_slug,
            recipes.id_user,
            recipes.id_category,
            recipes.createdAt,
            recipes.duration,
            recipes.description,
            categories.id AS category_id,
            categories.name AS category_name,
            categories.slug AS category_slug,
            COUNT(favoris.id_recipe) AS popularity
        FROM recipes
        JOIN favoris ON recipes.id = favoris.id_recipe
        JOIN categories ON recipes.id_category = categories.id
        GROUP BY recipes.id
        ORDER BY popularity DESC
        LIMIT 1
    ");
    
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        // Hydrater la catégorie
        $category = new CategoryModel($this->pdo);
        $category->hydrate([
            'id' => $data['category_id'],
            'name' => $data['category_name'],
            'slug' => $data['category_slug']
        ]);

        // Hydrater la recette
        $this->hydrate([
            'id' => $data['recipe_id'],
            'title' => $data['recipe_title'],
            'slug' => $data['recipe_slug'],
            'idUser' => $data['id_user'],
            'idCategory' => $data['id_category'],
            'createdAt' => $data['createdAt'],
            'duration' => $data['duration'],
            'description' => $data['description']
        ]);

        $this->setCategory($category);

        return $this;
    }

    return null;
}

 /**
 * @return RecipeModel[]
 */

public function getAllRecipesWithCategory() :array {
      $stmt = $this->pdo->prepare('SELECT * FROM `recipes`
                              JOIN categories ON recipes.id_category = categories.id');
     $stmt->execute();

      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $recipes = [];

      foreach($results as $data) {
            $categoryData = [
         'id' => $data['id'],
         'name' => $data['name']
      ];

         $category = new CategoryModel($this->pdo);
         $category->hydrate($categoryData);

         $recipe = new RecipeModel($this->pdo);
         $recipe->hydrate($data);
         $recipe->setCategory($category);

         $recipes[] = $recipe;

      }

      return $recipes;
    
}

 /**
 * @return RecipeModel[]
 */
public function getAllRecipesByCategory($idCategory) :array {
    $stmt = $this->pdo->prepare('
    SELECT 
    recipes.id AS recipe_id, 
    recipes.title, 
    recipes.id_user, 
    recipes.slug,
    recipes.createdAt, 
    recipes.duration, 
    recipes.description, 
    categories.name, 
    categories.id AS category_id,
    categories.image 
    FROM `recipes` 
    JOIN categories ON recipes.id_category = categories.id 
    WHERE categories.id = :id;
    ');

    $stmt->execute(['id' => $idCategory]); // probleme ici
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $recipes = [];

    foreach($results as $data) {

      $categoryData = ['id' => $data['category_id'],
                       'name' => $data['name'],
                       'image'=> $data['image']
                     ];

      $category = new CategoryModel($this->pdo);
      $category->hydrate($categoryData);

      $recipe = new RecipeModel($this->pdo);
      $recipe->hydrate($data);
      $recipe->setCategory($category);

      $recipes[] = $recipe;

    }

    return $recipes;
}

 
 }


