<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use Carbe\App\Models\RecipeModel;
use PDO;

class UserModel extends BaseModel {
   
  protected string $table = 'users';

  private string $name;
  private string $firstname;
  private string $email;
  private string $password;
  private string $role;
  private string $createdAt; 

/**
* @param array <string, mixed> $data
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

public function getFirstname() :string {
    return $this->firstname;
  }

public function setFirstname(string $firstname) :void {
    $this->firstname = $firstname;
  }

public function getEmail() :string {
     return $this->email;
  }

public function setEmail(string $email) :void {
    $this->email = $email;
  }

public function getPassword() :string {
   return $this->password;
  }

public function setPassword(string $password) :void {
    $this->password = password_hash($password, PASSWORD_DEFAULT); 
  }

public function getRole() :string {
    return $this->role;
  }

public function setRole(string $role) :void {

    $this->role = $role;

  }

public function getCreatedAt() :string {
    return $this->createdAt;
  }

public function setCreatedAt(string $createdAt) :void {

    $this->createdAt = $createdAt;
  }



public function findUserByEmail(string $email) :?UserModel {
    $stmt = $this->pdo->prepare('SELECT id, name, firstname, password, role FROM users WHERE email = :email');
    $stmt->execute([
      'email' => $email
    ]);

  $result =$stmt->fetch(PDO::FETCH_ASSOC);

     if (!$result) {
        return null;
    }

  return new UserModel($result);

}


public function update() : bool { // modif utilisateur

      $stmt = $this->pdo->prepare("UPDATE users SET name = :name, firstname = :firstname, email = :email, password = :password WHERE id = :id");
    
      return $stmt->execute([
          'name' => $this->getName(),
          'firstname' => $this->getFirstname(),
          'email' => $this->getEmail(),
          'password' => $this->getPassword(),
          'role' => $this->getRole(),
          'id' => $this->getId()
      ]);
      
  }



/**
 * @return RecipeModel[]
 */

 public function getFavoris() :array {
      $stmt = $this->pdo->prepare("SELECT users.id, users.name, firstname, email, role, favoris.id_user, recipes.*, categories.name
                                  FROM users
                                  JOIN favoris ON favoris.id_user = users.id
                                  JOIN recipes ON favoris.id_recipe = recipes.id
                                  JOIN categories ON categories.id = recipes.id_category
                                  WHERE users.id = :id");

     $stmt->execute([
        'id' => $this->getId()
      ]);

      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (!empty($data)) {
        $this->hydrate([
            'id' => $data[0]['id'], 
            'name' => $data[0]['name'], 
            'firstname' => $data[0]['firstname'],
            'email' => $data[0]['email'],
            'role' => $data[0]['role'],
        ]);
    }
     
      $recipes = [];

      foreach($data as $row) {
        $recipe = new RecipeModel($this->pdo);
        $recipe->hydrate([
            'id' => $row['id'],
            'title' => $row['title'],
            'slug' => $row['slug'],
            'duration' => $row['duration'],
            'description' => $row['description']

        ]);


         $category = new CategoryModel($this->pdo);
         $category->hydrate([
        'name' => $row['name']
          ]);
        
        $recipe->setCategory($category);
        $recipes[] = $recipe;

      }

    return $recipes;
  }


}

