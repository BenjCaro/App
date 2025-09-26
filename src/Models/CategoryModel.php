<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use PDO;

class CategoryModel extends BaseModel {
    
    protected string $table = "categories";

    private string $name;
    private string $slug;
    private ?string $image;
    private int $totalRecipes = 0;

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

  public function getSlug() : string {
     return $this->slug;
  }

  public function getTotalRecipes() :int {
    return $this->totalRecipes;
  }

  public function setTotalRecipes(int $totalRecipes):void {
    $this->totalRecipes = $totalRecipes;
  }

  public function setSlug(string $slug) : void {
     $this->slug = $slug;
  }

  public function getImage() :?string {
    return $this->image;
  }

  public function setImage(?string $image) :void {
    $this->image = $image;
  }

  public function save() :bool {
     $stmt = $this->pdo->prepare("INSERT INTO categories (name, slug)
     VALUES (:name, :slug)");
     
     return $stmt->execute([

        'name' => $this->getName(),
        'slug' => $this->getSlug()
     ]);
  }

/**
 * @return array<string, mixed>|false
 * 
 */

public function getCatByName(string $name) :array|false
 {
    
     $stmt = $this->pdo->prepare('SELECT categories.id, categories.name
      FROM `categories` 
      WHERE categories.name = :name');
      $stmt->execute(['name' => $name]);
      $results= $stmt->fetch(PDO::FETCH_ASSOC);

      return $results ?: false;

 }
 
/**
 * @return CategoryModel|null
 */


 public function getCatBySlug(string $slug) :?CategoryModel {
    
     $stmt = $this->pdo->prepare('SELECT categories.id, categories.name, categories.slug
      FROM `categories` 
      WHERE categories.slug = :slug');
      $stmt->execute(['slug' => $slug]);
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
        return null; 
    }

      $category = new CategoryModel($this->pdo);
      $category->hydrate($data);

      return $category;
 }


 /**
  * 
  * @return CategoryModel[]
  */

public function searchCategoryWithName($search) :array {
    $stmt = $this->pdo->prepare("
         SELECT categories.name,
         COUNT(recipes.id) AS total_recipes
         FROM categories
         LEFT JOIN recipes ON recipes.id_category = categories.id
         WHERE name LIKE :search
         GROUP BY categories.name;
    ");

    $stmt->execute(['search' => "%$search%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $categories = [];

    foreach($results as $data) {
       $category = new CategoryModel($this->pdo);
       $category->hydrate($data);
       $category->setTotalRecipes($data['total_recipes']);
       $categories[] = $category;

    }

    return $categories;

}


/**
 * Méthode permettant d'afficher le nombre de recettes par catégorie
 * LEFT JOIN permet d'afficher les catégories sans recette
 * @return CategoryModel[]
 */

public function countRecipesByCat() :array {
      $stmt = $this->pdo->prepare("
         SELECT categories.name, categories.slug, categories.image,
         COUNT(recipes.id) AS total_recipes
         FROM categories
         LEFT JOIN recipes ON recipes.id_category = categories.id
         GROUP BY categories.id, categories.name;
      ");
      $stmt->execute();

      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $categories = [];

      foreach($results as $data) {
        $category = new CategoryModel($this->pdo);
        $category->hydrate($data);
       // $category->setTotalRecipes($data['total_recipes']);

        $categories[] = $category;

      }

      return $categories;


}

}