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
   private  $createAt; 

  // mettre en place un construct et hydrate() (à dev dans le BaseModel)

}