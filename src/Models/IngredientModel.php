<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use PDO;

class IngredientModel extends BaseModel {

    protected string $table = 'ingredients';

    private string $name;
    private string $type;

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
        return $this->name;
  }
  
  public function setType(string $name) :void  {
       $this->name = $name;
  }

  public function save() :bool {
     $stmt = $this->pdo->prepare("INSERT INTO categories (name, type)
     VALUES (:name, :type)");
     
     return $stmt->execute([

        'name' => $this->getName(),
        'type' => $this->getType()
     ]);
  }

  public function update() :bool {
    $stmt = $this->pdo->prepare("UPDATE categories SET name = :name, type = :type WHERE id= :id");

    return $stmt->execute([

        'id' => $this->getId(),
        'name' => $this->getName(),
        'type' => $this->getType()

    ]);
  }

}