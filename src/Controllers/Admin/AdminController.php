<?php 

namespace Carbe\App\Controllers\Admin;

use Carbe\App\Controllers\BaseController;
use Carbe\App\Models\RecipeModel;
use Exception;
use Carbe\App\Models\UserModel;
use Carbe\App\Services\Flash;
use Carbe\App\Services\Csrf;
use Carbe\App\Services\Auth;

class AdminController extends BaseController  {

    public function viewAllUsers() :void {

        Auth::isAdmin();
        
        $userModel = new UserModel($this->pdo);
        $users = $userModel->getAllUsers();


        $this->render('all_users', [

            'title' => 'Petit Creux | Tous les utilisateurs',
            'users' => $users
        ]);
    }

    public function deleteUser(int $id) :void {

            
            Auth::isAdmin();

            $userModel = new UserModel($this->pdo);
            $user = $userModel->findById($id);

            if(!$user) {
                Flash::set('Utilisateur non trouvé.', 'secondary');
                exit;
            }

            try {
                
                $userModel->delete($id);
                Flash::set("Utilisateur supprimé avec succés !", "primary");
              
            }

            catch(Exception $e) {

                Flash::set("Erreur dans la suppression", "secondary");        
        }
        
        header('Location: /admin');
        exit;
    }

    public function updateRole(int $id, string $role) :void {

        session_start();

        Auth::isAdmin();

        $token = $_POST['_token'];
        Csrf::check('admin_update_role', $token, '/admin');

        $role = $_POST['role'];

        $user = new UserModel($this->pdo);
        
        try{
             $user->update($id, [
            'role' => $role
        ]);

            
            Flash::set("Le role utilisateur a été modifiée.", "primary");
            header("Location: /admin");
            exit;

        } catch(Exception $e) {

           Flash::set("La modifcation a échouée", "secondary");
           header("Location: /admin");
        }

    }

    public function viewAllRecipes():void {

        Auth::isAdmin();

        $recipeModel = new RecipeModel($this->pdo);
       $recipes = $recipeModel->getAllRecipes();

        $this->render('all_recipes', [
            'title' => 'Petit Creux | Toutes les recettes',
            'recipes' => $recipes
        ]);
    }


}