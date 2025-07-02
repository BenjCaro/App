<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use Carbe\App\Models\IngredientModel;
use Carbe\App\Models\RecipeIngredientModel;

use PDO;
use Exception;


class RecipeModel extends BaseModel {

   protected string $table = 'recipes';

  
    private array $ingredients = [];
    private string $title;
    private string $slug;
    private int $idUser;
    private int $idCategory;
    private string $createdAt;
    private int $duration;
    private string $content;

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

  public function getCreatedAt() :string {
    return $this->createdAt;
  }

  public function getDuration() :int {
     return $this->duration;

  }

  public function setDuration(int $duration) :void {
     $this->duration = $duration;
  }

  public function getDescription() :string {
     return $this->content;
  }

  public function setDescription(string $content) :void {
    $this->content = $content;
  }

   public function getIngredients(): array {
      return $this->ingredients;
}  


  public function getRecipe() {

      if (!$this->getId()) {
         throw new Exception("La recette n'existe pas.");
      }  

      $stmt = $this->pdo->prepare("SELECT *
               FROM recipes AS r
               JOIN recipes_ingredients ON r.id = recipes_ingredients.id_recipe
               JOIN ingredients ON ingredients.id = recipes_ingredients.id_ingredient
               WHERE r.id = :id;");
      
      $stmt->execute([
         'id' => $this->getId()
      ]);
   

      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $this->hydrate($data[0]);
      

      $ingredients = [];

      foreach($data as $row) {
         $ingredient = new IngredientModel($this->pdo);
         $ingredient->hydrate([
                'id' => $row['id_ingredient'],
                'name' => $row['name'],
                'type' => $row['type']
            ]);

         $recipeIngredient = new RecipeIngredientModel($this->pdo);
         $recipeIngredient->hydrate([

                  'quantity' => $row['quantity'],
                  'unit' => $row['unit']

          ]);

         $recipeIngredient->setIngredient($ingredient);
    
         $ingredients[] = $recipeIngredient;
      }
     
      $this->ingredients = $ingredients;
      return $data;

   }

   /**
    * public function - getMostFavoritedRecipe() {
    *     $stmt = $this->pdo->prepare ("SELECT *, COUNT(favoris.id_recipe) FROM recipes
               *   JOIN favoris ON recipes.id = favoris.id_recipe
               *   GROUP BY recipes.id
               *   LIMIT 1;");
    *
    *   }
    * 

    */
}


// recette la plus récente
//SELECT * FROM `recipes` 
//ORDER BY createAt DESC LIMIT 1;