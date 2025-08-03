<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use PDO;

class PostModel extends BaseModel {
   protected string $table = 'posts';

   private string $title;
   private string $content;
   private int $id_user;
   private int $id_recipe;
   private string $createdAt;
   private bool $isApproved = false;


/**
 * @param array<string, mixed> $data
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
   
public function getContent() :string {
    return $this->content;
   }

public function setContent(string $content) :void {
    $this->title = $content;
   }

public function getIdUser() :int {
   return $this->id_user;
}

public function setIdUser(int $id_user): void {
   $this->id_user = $id_user;
}

public function getIdRecipe() :int {
   return $this->id_recipe;
}

public function setIdRecipe(int $id_recipe) :void {
   $this->id_recipe = $id_recipe;
}

public function getCreatedAt() :string {
    return $this->createdAt;
  }

public function setCreatedAt(string $createdAt) :void {
    $this->createdAt = $createdAt;
  }

public function getIsApproved() :bool {
    return $this->isApproved;
  }

public function setIsApproved(bool $isApproved) :void {
    $this->isApproved = $isApproved;
    
  }

public function approve(): void {
    $this->isApproved = true;
}

public function showComments() :array {

   $stmt = $this->pdo->prepare("SELECT *  FROM posts");
   $stmt->execute();
   $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   if(!$data) {
     
     return [];
   }

   $posts = [];
   foreach($data as $row) {
      $post = new PostModel($this->pdo);
      $post->hydrate($row);
      $posts[] = $post;
   }

   return $posts;

  
}

}