<?php 

namespace Carbe\App\Controllers\Admin;

use Carbe\App\Controllers\BaseController;
use Carbe\App\Models\CategoryModel;
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
                exit;
            }

            catch(Exception $e) {

                Flash::set("Erreur dans la suppression", "secondary");  
                exit;      
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

    public function deleteRecipe(int $id) {

        Auth::isAdmin();

        $recipeModel = new RecipeModel($this->pdo);
        $recipe = $recipeModel->findById($id);

        if(!$recipe) {
            Flash::set('Recette non trouvée.', 'secondary');
            exit;
        }

        try {

            $recipeModel->delete($id);
            Flash::set("Recette supprimée avec succés !", "primary");
        } catch(Exception $e) {
            Flash::set("Erreur dans la suppression", "secondary");
        }

        header('Location: /admin');
        exit;
    }

    public function publishRecipe(int $id, string $slug, string $state) {
        
        session_start();

        Auth::isAdmin();
        $token = $_POST['_token'];
        Csrf::check('admin_update_recipe', $token, '/recette/' . $slug);

        $state = $_POST['state'];
        $id = $_POST['id'];

        $recipe = new RecipeModel($this->pdo);

        try { 
        
            $recipe->update($id, [
                'state' => $state
            ]);
            Flash::set("Le statut de la recette a ete modifié.", "primary");
            header("Location: /recette/" . $slug);
            exit;


        } catch(Exception $e) {

            Flash::set("La modifcation a échouée", "secondary");
            header("Location: /recette/" . $slug);


        }


    }
    
   /**
   * Ajouter une catégorie via un formulaire présent dans le panneau ADMIN
   * 
   * 
   */

    public function createCategory(array $data) :void {

       session_start();
       Auth::isAdmin();

      
       // $token = $data['_token'];

        // Csrf::check();
       $name = trim($data['name']);
       $slug = trim($data['slug']);

       $categoryModel = new CategoryModel($this->pdo);
       $category = $categoryModel->getCatByName($name);

       if($category) {
            Flash::set('La catégorie existe déja', 'secondary');
            exit;
       }

       // gérer l'image et l'ajouter dans categoryData
       
       $categoryData = [
        'name' => $name,
        'slug' => $slug
       ];
       
      try {
        $model = new CategoryModel($this->pdo);
        $model->insert($categoryData);

        Flash::set("Ajout de la catégorie réussi.", "primary");
        header("Location: /admin");
        exit;

      } catch(Exception $e) {
         
        Flash::set("Catégorie non ajoutée.", "secondary");
        // prévoir la redirection
        // exit;
      }



    }

    // supprimer une catégorie

    public function deleteCategory(int $id) :void {
        
        session_start();
        Auth::isAdmin();

        $categoryModel = new CategoryModel($this->pdo);
        $category= $categoryModel->findById($id);

        if(!$category) {
            Flash::set('Catégorie non trouvée.', 'secondary');
            exit;
        }

        try {
            $categoryModel->delete($id);
            Flash::set("Utilisateur supprimé avec succés !", "primary");
            exit;
        } catch(Exception $e) {

            Flash::set("Erreur dans la suppression", "secondary");  
            exit;   
        } 
    }

    // modifier une catégorie

    public function updateCategory(int $id, array $data) :void {

        session_start();
        Auth::isAdmin();

        // $token = $_POST['token'];
        // Csrf::check();
        $name = trim($data['name']);
        $slug = trim($data['slug']);

        $categoryModel = new CategoryModel($this->pdo);
        $category = $categoryModel->getCatByName($name);

        if($category && $category['id'] !== $id) {
                Flash::set('La catégorie existe déja', 'secondary');
                exit;
        }

        $categoryData = [
        'name' => $name,
        'slug' => $slug
       ];

       try {

        $model = new CategoryModel($this->pdo);
        $model->update($id ,$categoryData);

        Flash::set("Modification de la catégorie réussie.", "primary");
        header("Location: /admin");
        exit;

       } catch(Exception $e) {
            Flash::set("Catégorie non modifiée.", "secondary");
            // prévoir la redirection
            // exit;
       }


        
    }

}