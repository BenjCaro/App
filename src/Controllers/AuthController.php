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
                     $_SESSION['flash'] = "Email ou mot de passe manquant.";
                    header("Location: /login");
                    exit();
                }
                
                $user= $this->userModel->findUserByEmail($email);
        
                if(!$user) {
                   $_SESSION['flash'] = "Email ou mot de passe manquant.";
                    header("Location: /login");
                    exit();
                    $_SESSION['flash'] = "Utilisateur non trouvé.";
                    header("Location: /login");
                    exit();


                }

                if (password_verify($password, $user->getPassword())) {
                $_SESSION['user'] = [
                    'id' => $user->getId()
                ];
                $_SESSION['flash'] = "Connexion réussie. Bienvenue " . $user->getFirstname() . "!";
                header("Location: /");
                exit();
            } else {
                $_SESSION['flash'] = "Mot de passe incorrect.";
                header("Location: /login");
                exit();
            }

    }

    private function validateLoginInput($email, $password): bool {
            return isset($email, $password) && !empty($email) && !empty($password);
    }


}



?>
