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

/**
 * @return PostModel[]
 */

public function showApprovedComments(int $idRecipe) :array {

   $stmt = $this->pdo->prepare(
      "SELECT 
       posts.id,
       posts.title,
       posts.content,
       posts.createdAt,
       posts.id_user,
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

/**
 * @return PostModel|null
 */

public function getCommentById(int $id) {
    $stmt = $this->pdo->prepare(
        "SELECT 
            posts.id,
            posts.title AS post_title,
            posts.content,
            posts.createdAt,
            recipes.title AS recipe_title,
            recipes.createdAt AS recipe_createdAt
        FROM posts 
        JOIN recipes ON recipes.id = posts.id_recipe
        WHERE posts.id = :id"
    );

    $stmt->execute([
        'id' => $id
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        return null;
    }

   
    $post = new PostModel($this->pdo);
    $post->hydrate([
        'id'        => $data['id'],
        'title'     => $data['post_title'],
        'content'   => $data['content'],
        'createdAt' => $data['createdAt']
    ]);

   
    $recipe = new RecipeModel($this->pdo);
    $recipe->hydrate([
        'title' => $data['recipe_title'],
        'createdAt' => $data['recipe_createdAt']
    ]);

   
    $post->setRecipe($recipe);
    return $post;
}


/**
 * @return PostModel[]
 */



public function getCommentsByUser(int $id) :array {

   $stmt = $this->pdo->prepare("SELECT posts.title, posts.id, posts.isApproved, posts.createdAt, recipes.title as recipe_title, recipes.id as recipe_id, recipes.slug FROM posts 
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


public function getLastestPost() :array {
    $stmt = $this->pdo->prepare("
    SELECT 
    posts.id,
    posts.title,
    posts.createdAt,
    users.name AS user_name,
    users.firstname AS user_firstname,
    recipes.title AS recipe_title,
    recipes.slug AS recipe_slug
    FROM posts
    JOIN users ON users.id = posts.id_user
    JOIN recipes ON recipes.id = posts.id_recipe
    ORDER BY createdAt DESC
    LIMIT 5
    ");

    $stmt->execute();
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
            'title' => $row['recipe_title'],
            'slug' => $row['recipe_slug']
      ]);

      $user = new UserModel($this->pdo);
      $user->hydrate([
         'name' => $row['user_name'],
         'firstname' => $row['user_firstname']
      ]);

      $post->setRecipe($recipe);
      $post->setAuthor($user);

     $posts[] = $post;
   }

   return $posts;
}

}