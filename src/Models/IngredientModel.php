<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use PDO;

class IngredientModel extends BaseModel {

    protected string $table = 'ingredients';

    private string $name;
    private string $type;

/**
 * @param array<string, mixed> $data
 */

    public function __construct(PDO $pdo, array $data = []) {
        
      parent::__construct($pdo);
       
      if (!empty($data)) {
            $this->hydrate($data);
      }

    }

    public function getName() :string {
        return $this->name;
  }
  
    public function setName(string $name) :void  {
       $this->name = $name;
  }

  public function getType() :string {
        return $this->type;
  }
  
  public function setType(string $type) :void  {
       $this->type = $type;
  }


/**
 * @return array<string, mixed>|false
 * 
 */

 public function getIngredientName(string $name) :array|false {
      $stmt= $this->pdo->prepare("SELECT
         ingredients.id, ingredients.name, ingredients.type
         FROM ingredients 
         WHERE ingredients.name = :name");

      $stmt->execute(['name' => $name]);
      $results = $stmt->fetch(PDO::FETCH_ASSOC);

      return $results ?: false;
 }

 public function findIngredient(string $name): array {

    $stmt = $this->pdo->prepare("SELECT
         ingredients.id, ingredients.name, ingredients.type
         FROM ingredients 
         WHERE ingredients.name LIKE :name");
    $stmt->execute([':name' => "%$name%"]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}