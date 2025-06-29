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
   private string $createAt; 

  // mettre en place un construct et hydrate() (à dev dans le BaseModel)

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

  public function setPassword(string $password) :void {
    $this->password = password_hash($password, PASSWORD_DEFAULT); 
  }

  public function getRole(string $role) :string {
    return $this->role;
  }

  public function getCreateAt() :string {
    return $this->createAt;
  }
}