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
use Carbe\App\Services\SlugService;

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

    public function createCategory() :void {

       session_start();
       Auth::isAdmin();

      
       $token = $_POST['_token'];

       Csrf::check("create_category", $token, "/admin/categories");
       $name = isset($_POST['name']) ? trim($_POST['name']) : null;

       if(empty($name)) {
           Flash::setErrorsForm("name", 'Nom Obligatoire', 'secondary');
           exit;
       }

       
       $categoryModel = new CategoryModel($this->pdo);
       $category = $categoryModel->getCatByName($name);

       if($category) {
            Flash::set('La catégorie existe déja', 'secondary');
            exit;
       }

       $slug = SlugService::generateSlug($name);

       $imageName = basename($_FILES['image']['name']);
       $imageTmp = $_FILES['image']['tmp_name'];

       // contrôler la size
       $imageSize = $_FILES['image']['size'];
       $allowedMaxSize = 2* 1024 *1024; 

       if($imageSize === 0) {
          Flash::setErrorsForm("image","Image vide", "secondary");
         header("Location: /admin/categories");
         exit;  
       }

       if($imageSize > $allowedMaxSize) {
         Flash::setErrorsForm("image","Image trop lourde", "secondary");
         header("Location: /admin/categories");
         exit;  
       }

       // contrôler le type 

       $allowedTypes = [".svg", ".jpg", ".png"];
       $extensionImage = strrchr($imageName, '.');
       
       // contrôler le mime 

       $finfo = new \finfo(FILEINFO_MIME_TYPE); // Retourne le type mime

        /* Récupère le mime-type d'un fichier spécifique */
        
       $imageMime = $finfo->file($imageTmp);

       $allowedMimes = [
            'image/jpeg',
            'image/png',
            'image/svg+xml'
        ];

      
       if(isset($imageTmp) && is_uploaded_file($imageTmp)) {
        
            if(!in_array($extensionImage, $allowedTypes) || !in_array($imageMime, $allowedMimes)){
                Flash::set("Extension non autorisée", "secondary");
                header("Location: /admin/categories");
                exit;
            };

            $newImageName = uniqid('cat_', true) . $extensionImage;
            $destination = dirname(__DIR__, 3) . '/public/assets/images/categories/' . $newImageName;

            if (!move_uploaded_file($imageTmp, $destination)) {
                Flash::set("Échec du transfert de l'image", "secondary");
                header("Location: /admin/categories");
                exit;
            }
            
            } else {
                Flash::set("Erreur dans l'upload de l'icone : mauvaise extension.", "secondary");
                header('Location: /admin/categories');
                exit;
        }

        // fin du contrôle de l'image

       $categoryData = [
        'name' => $name,
        'slug' => $slug,
        'image' => $newImageName
       ];
       
      try {

        $model = new CategoryModel($this->pdo);
        $model->insert($categoryData);

        Flash::set("Ajout de la catégorie réussi.", "primary");
        header("Location: /admin/categories");
        exit;

      } catch(Exception $e) {
         
        Flash::set("Catégorie non ajoutée.", "secondary");
        header("Location: /admin/categories");
        exit;
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
            Flash::set("Catégorie supprimée avec succés !", "primary");
            header('Location: /admin/categories');
            exit;
        } catch(Exception $e) {

            Flash::set("Erreur dans la suppression", "secondary");  
            header('Location: /admin/categories');
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