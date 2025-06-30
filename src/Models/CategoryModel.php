<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use PDO;

class CategoryModel extends BaseModel {
    
    protected string $table = "categories";

    private string $name;
    private string $slug;

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

  public function getSlug() : string {
     return $this->slug;
  }

  public function setSlug(string $slug) : void {
     $this->slug = $slug;
  }

  public function save() :bool {
     $stmt = $this->pdo->prepare("INSERT INTO categories (name, slug)
     VALUES (:name, :slug)");
     
     return $stmt->execute([

        'name' => $this->getName(),
        'slug' => $this->getSlug()
     ]);
  }

  public function update() :bool {
    $stmt = $this->pdo->prepare("UPDATE categories SET name = :name, slug = :slug WHERE id= :id");

    return $stmt->execute([

        'id' => $this->getId(),
        'name' => $this->getName(),
        'slug' => $this->getSlug()

    ]);
  }

}