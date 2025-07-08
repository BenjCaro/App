<?php
namespace Carbe\App\Controllers;

use Carbe\App\Models\UserModel;

class AuthController extends BaseController {

private UserModel $userModel;

    public function __construct()
    {   
        parent::__construct();
        $this->userModel = new UserModel($this->pdo);
        
    }
        
    public function login(string $email, string $password) :void {
                
                if (!$this->validateLoginInput($email, $password)) {
                    echo 'Email ou mot de passe manquant.';
                    exit();
                }
                
                $user= $this->userModel->findUserByEmail($email);
        
                if(!$user) {
                    echo("Utilisateur non trouvé");
                    exit();
                }

                if ($user && password_verify($password, $user->getPassword())) {
                    session_start();
                    $_SESSION['user'] = [
                    'id' => $user->getId(),
                ];

                header("Location: /");
                exit();

                } else {
                    echo "Mot de passe incorrect.";
                    exit();
                }
    }

    private function validateLoginInput($email, $password): bool {
            return isset($email, $password) && !empty($email) && !empty($password);
    }


}



?>
