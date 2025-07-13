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

        $favoris =  $user->getFavoris();

        $this->render('Users\mon-compte', [
            'title' => 'Petit Creux | Mon Compte ',
            'user' => $user,
            'favoris' => $favoris
        ]);        
    }

    public function createUser(array $data) :void {
        session_start();
        // verifier les données 
        $name = trim($data['name']);
        $firstname = trim($data['firstname']);
        $email = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
        $password = trim($data['password']);
        $description = trim($data['description']);

       $errors = [];

        if (!$email) {
            $errors['email'] = "Adresse e-mail invalide.";
        }

        if (strlen($password) < 8) {
            $errors['password'] = "Le mot de passe doit contenir au moins 8 caractères.";
        }

        if (empty($name) || empty($firstname)) {
            $errors['name'] = "Nom et prénom sont obligatoires.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /inscription');
            exit;
        }

        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Préparation des données à insérer
        $userData = [
            'name' => $name,
            'firstname' => $firstname,
            'email' => $email,
            'password' => $hashedPassword,
            'description' => $description
        ];

        $this->userModel->insert($userData);
        $_SESSION['flash'] = "Bienvenue, inscription Réussie!";
        header('Location: /');
    }
}
