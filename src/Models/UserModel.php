<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use PDO;

class UserModel extends BaseModel {
   
  protected string $table = 'users';

  private string $name;
  private string $firstname;
  private string $email;
  private string $password;
  private string $role;
  private string $createdAt; 

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

  public function save() :bool { // creation d'utilisateur 

      $stmt = $this->pdo->prepare("INSERT INTO users (name, firstname, email, password, role) 
      VALUES (:name, :firstname, :email, :password, :role)");
      
      return $stmt->execute([
        'name' => $this->getName(),
        'firstname' => $this->getFirstname(),
        'email' => $this->getEmail(),
        'password' => $this->getPassword(),
        'role' => $this->getRole()
      ]);
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



}