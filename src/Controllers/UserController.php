<?php

namespace Carbe\App\Controllers;
use Carbe\App\Models\UserModel;

class UserController extends BaseController {

    private UserModel $userModel;
      
         public function __construct()
    {   
        parent::__construct();
        $this->userModel = new UserModel($this->pdo);
        
    }


    private function isAuth(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['auth_user'])) {
            $_SESSION['flash'] = "Connectez-vous pour accèder à cette page!";
            header('Location: /login');
            exit();
        }
    }

    
         
    public function getMyProfil(): void {

        $this->isAuth();

        $userId = $_SESSION['auth_user']['id'];
        $user = $this->userModel->findById($userId);

        $this->render('Users\mon-compte', [
            'user' => $user
        ]);

             
    }
}
