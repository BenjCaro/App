<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use PDO;
use Exception;


class RecipeModel extends BaseModel {

   protected string $table = 'recipes';

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

  public function getRecipe() {

      if (!$this->getId()) {
         throw new Exception("L'id de la recette n'est pas défini.");
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
      return $data;
   }
}