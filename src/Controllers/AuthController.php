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
                

                session_start();
                if (!$this->validateLoginInput($email, $password)) {
                     $_SESSION['flash'] = "Identifiants invalides";
                    header("Location: /login");
                    exit();
                }
                
                $auth_user= $this->userModel->findUserByEmail($email);
        
                if(!$auth_user) {
                   $_SESSION['flash'] = "Email ou mot de passe manquant.";
                    header("Location: /login");
                    exit();

                }

                if (password_verify($password, $auth_user->getPassword())) {
                $_SESSION['auth_user'] = [
                    'id' => $auth_user->getId()
                ];
                $_SESSION['flash'] = "Connexion réussie. Bienvenue " . $auth_user->getFirstname() . "!";
                header("Location: /");
                exit();
            } else {
                $_SESSION['flash'] = "Mot de passe incorrect.";
                header("Location: /login");
                exit();
            }

    }

    private function validateLoginInput(string $email, string $password): bool {
            return isset($email, $password) && !empty($email) && !empty($password);
    }


}



?>
