<?php

namespace Carbe\App\Controllers;

use Carbe\App\Models\RecipeModel;
use Carbe\App\Models\UserModel;
use Carbe\App\Models\PostModel;
use Carbe\App\Services\Auth;
use Carbe\App\Services\Flash;
use Carbe\App\Services\Csrf;

use Exception;
use \PDOException;

class UserController extends BaseController {

    private UserModel $userModel;
    private RecipeModel $recipeModel;
    private PostModel $postModel;
      
    public function __construct()
    {   
        parent::__construct();
        $this->userModel = new UserModel($this->pdo);
        $this->recipeModel = new RecipeModel($this->pdo);
        $this->postModel = new PostModel($this->pdo);
    }
         
    public function getMyProfil(): void {

        Auth::isAuth();

        $userId = $_SESSION['auth_user']['id'];
        $user = $this->userModel->findById($userId);

        $favoris =  $user->getFavoris();
        $userRecipes = $this->recipeModel->getRecipesByUser($userId);

        $posts = $this->postModel->getCommentsByUser($userId);

        $this->render('Users\mon-compte', [
            'title' => 'Petit Creux | Mon Compte ',
            'user' => $user,
            'favoris' => $favoris,
            'userRecipes' => $userRecipes,
            'posts' => $posts
        ]);        
    }


 /**
 * @param array<string, string> $data
 */
    public function createUser(array $data) :void {
        session_start();
        
        $token = $data['_token'];
        $name = trim($data['name']);
        $firstname = trim($data['firstname']);
        $email = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
        $password = trim($data['password']);
        $confirm = trim($data['confirm-password']);
        $description = trim($data['description']);
        
        $errors = [];
        $_SESSION['old'] = $_POST;
        Csrf::check("submit", $token, "/inscription");

        if (!$email) {
            $errors['email'] = "Adresse e-mail invalide.";
        } elseif (!$this->availableEmail($email)) {
            $errors['email'] = "Adresse e-mail déja utilisée.";
        }

        if (strlen($password) < 8) {
            $errors['password'] = "Le mot de passe doit contenir au moins 8 caractères.";
        }
        
        if( $password !== $confirm) {
             $errors['confirm'] = "Les mots de passe ne correspondent pas.";
         }

        if (empty($name) || empty($firstname)) {
            $errors['name'] = "Nom et prénom sont obligatoires.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            
            header('Location: /inscription');
            exit;
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userData = [
            'name' => $name,
            'firstname' => $firstname,
            'email' => $email,
            'password' => $hashedPassword,
            'description' => $description
        ];

        

        try {

            $this->userModel->insert($userData);
           
            Flash::set("Bienvenue, inscription réussie !", "primary");
            header('Location: /');
            exit;


                } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                
                $_SESSION['errors']['email'] = "Cet email est déjà enregistré.";
                header('Location: /inscription');
                exit;

            } else {
                
                
                Flash::set("Une erreur technique est survenue. Veuillez réessayer plus tard.", "secondary");
                error_log($e->getMessage());
                header('Location: /inscription');
                exit;
            }
        }  
    }


/**
 * @param array<string, string> $data
 */

  public function updateInformations(int $id, array $data) :void {
    $errors = [];
    $user = new UserModel($this->pdo);

    $token = $data["_token"];
    $name = trim($data['name'] ?? '');
    $firstname = trim($data['firstname'] ?? '');
    $emailInput = trim($data['email'] ?? ''); // valeur brute
    $email = filter_var($emailInput, FILTER_VALIDATE_EMAIL); // email validé ou false

    Csrf::check("update_profil", $token, "/mon-compte");

    // Vérif champs obligatoires
    if (!$name || !$firstname || !$emailInput) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    // Vérif email
    if ($emailInput && !$email) {
        $errors[] = "Adresse e-mail invalide.";
    } elseif ($email && !$this->availableEmail($email, $id)) {
        $errors[] = "Adresse e-mail déjà utilisée.";
    }

    
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: /mon-compte");
        exit;
    }

    
    try {
        $user->update($id, [
            'name' => $name,
            'firstname' => $firstname,
            'email' => $email
        ]);

        
        Flash::set("Vos informations ont été mises à jour.", "primary");       
        header("Location: /mon-compte");
        exit;

    } catch(Exception $e) {
        error_log("Erreur update user : " . $e->getMessage());
        $_SESSION['errors'] = ["La modification a échoué."];
        header("Location: /mon-compte");
        exit;
    }
}


/**
 * @param array<string, string> $data
 */

    public function updateDescription(int $id, array $data) :void {
        
        $token = $data["_token"];
        $description = $data['description'] ?? null;
        Csrf::check("update_description", $token, "/mon-compte");
        $user = new UserModel($this->pdo);

        
        try{
             $user->update($id, [
            'description' => $description
        ]);

            
            Flash::set("Votre description a été modifiée.", "primary");
            header("Location: /mon-compte");
            exit;

        } catch(Exception $e) {

           $_SESSION['errors'] = "La modification a échouée.";
           header("Location: /mon-compte");
        }

    }

   private function availableEmail(string $email, ?int $currentUserId = null): bool {
    $user = $this->userModel->findUserByEmail($email);

    // Si aucun utilisateur trouvé → email dispo
    if (!$user) {
        return true;
    }

    // Si c'est l'utilisateur actuel → email considéré comme dispo
    if ($currentUserId !== null && $user->getId() === $currentUserId) {
        return true;
    }

    // Sinon email déjà pris par un autre utilisateur
    return false;
}

}


