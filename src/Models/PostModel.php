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
   private ?UserModel $author = null;
   private ?RecipeModel $recipe= null;

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
    $this->content = $content;
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


public function setAuthor(UserModel $user): void {
        $this->author = $user;
}

public function getAuthor(): ?UserModel {
        return $this->author;
 }

public function getRecipe(): ?RecipeModel {
   return $this->recipe;
}

public function setRecipe(?RecipeModel $recipe) :void {
    $this->recipe = $recipe;
}

public function showComments(int $idRecipe) :array {

   $stmt = $this->pdo->prepare(
      "SELECT 
       posts.id,
       posts.title,
       posts.content,
       posts.createdAt,
       users.name,
       users.firstname
      FROM posts JOIN users ON users.id = posts.id_user
      WHERE isApproved = 1
      AND posts.id_recipe = :id_recipe
      ORDER BY posts.createdAt DESC; ");
   $stmt->execute([
       'id_recipe' => $idRecipe
   ]);
   $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   if(!$data) {
     
     return [];
   }

   $posts = [];
   foreach($data as $row) {
      $post = new PostModel($this->pdo);
      $post->hydrate($row);

      $user = new UserModel($this->pdo);
      $user->hydrate([
            'id'        => $row['id'],
            'firstname' => $row['firstname'],
            'name'      => $row['name'],
        ]);

      $post->setAuthor($user);
      $posts[] = $post;
   }

   return $posts;

  
}


public function getCommentsByUser(int $id) :array {

   $stmt = $this->pdo->prepare("SELECT posts.title, posts.id, posts.isApproved, recipes.title as recipe_title, recipes.id as recipe_id, recipes.slug FROM posts 
   JOIN recipes ON posts.id_recipe = recipes.id
   WHERE posts.id_user = :id_user");
   $stmt->execute(['id_user' => $id]);
   $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

   if(!$data) {
      return [];
   }

   $posts = [];

   foreach($data as $row) {
      $post = new PostModel($this->pdo);
      $post->hydrate($row);
      $recipe = new RecipeModel($this->pdo);
      $recipe->hydrate([
         'id' => $row['recipe_id'],
         'title' => $row['recipe_title'],
         'slug' => $row['slug']
      ]);

      $post->setRecipe($recipe);
      $posts[] = $post;
   }

   return $posts;
}

}