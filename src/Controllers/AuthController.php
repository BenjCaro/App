<?php
namespace Carbe\App\Controllers;

use Carbe\App\Models\UserModel;
use Carbe\App\Services\Flash;
use Carbe\App\Services\Csrf;
/**
 * Controller qui gère la connexion d'un utilisateur à l'application
 */

class AuthController extends BaseController {

private UserModel $userModel;

    public function __construct()
    {   
        parent::__construct();
        $this->userModel = new UserModel($this->pdo);
        
    }
        
    public function login(string $token, string $email, string $password) :void {
                
                
                session_start();
                Csrf::check("signin",$token, "/login");
                $_SESSION['old'] = $_POST;
            
                if (!$this->validateLoginInput($email, $password)) {
                    
                    Flash::set("Identifiants invalides", "secondary");
                    header("Location: /login");
                    exit();
                }
                
                $auth_user= $this->userModel->findUserByEmail($email);
        
                if(!$auth_user) {
                   Flash::set("Utilisateur non trouvé, Verifier vos identifiants.", "secondary");
                    header("Location: /login");
                    exit();

                }

                if (password_verify($password, $auth_user->getPassword())) {
                
                $_SESSION['auth_user'] = [
                    'id' => $auth_user->getId()
                ];
                Flash::set("Connexion réussie. Bienvenue " . $auth_user->getFirstname() . "!", "primary");
                header("Location: /");
                exit();

            } else {
                
                Flash::set("Mot de passe incorrect", "secondary");
                header("Location: /login");
                exit();
            }

    }

/**
 * Methode privée au Controller pour vérifier si email et mot de passe ne sont pas vide
 * 
 */

private function validateLoginInput(?string $email, ?string $password): bool {
    return !empty($email) && !empty($password);
}



}



?>
