<?php 

namespace Carbe\App\Controllers\Admin;

use Carbe\App\Controllers\BaseController;
use Carbe\App\Services\Auth;
use Carbe\App\Models\IngredientModel;
use Carbe\App\Services\Csrf;
use Carbe\App\Services\Flash;
use Exception;


class AdminIngredientController extends BaseController {
      
    public function index() :void {

        Auth::isAdmin();

        $ingredientModel = new IngredientModel($this->pdo);
        $ingredients = $ingredientModel->findAll();

        $this->render('ingredients', [
                'title' => 'Petit Creux | Tout les ingrédients',
                'ingredients' => $ingredients
        ]);
    }   

    public function updateIngredient():void {
        
        session_start();
        Auth::isAdmin();

        $token = $_POST['_token'];

        Csrf::check("update_ingredient", $token, "/admin/ingredients");

        $ingredientModel = new IngredientModel($this->pdo);
        $id = isset($_POST['id']) ? trim($_POST['id']) : null;

        $ingredient = $ingredientModel->findById($id);

        if(!$ingredient) {
            Flash::set("L'ingrédient n'existe pas!", "secondary");
            header("Location: /admin/ingredients");
            exit;
        }

        $name = isset($_POST['name']) ? trim($_POST['name']) : null;

        $ingredientName = $ingredientModel->getIngredientName($name);

        if($ingredientName && (int)$ingredientName['id'] !== (int)$id) {
            Flash::set("L'ingrédient existe déja", "secondary");
            header("Location: /admin/ingredients");
            exit;
        }

        $type = isset($_POST['type']) ? trim($_POST['type']) : null;

        try {

            $ingredientModel->update($id, ['name' => $name, 'type' => $type]);
            Flash::set("Modification réussie", "primary");


        } catch(Exception $e) {
            error_log($e->getMessage());
            Flash::set("Erreur de modification", "secondary");
            exit;
        }

        header("Location: /admin/ingredients");
        exit;

    }

    public function deleteIngredient() {
         
        session_start();
        Auth::isAdmin();

        $token = $_POST['_token'];

        Csrf::check("delete_ingredient", $token, "/admin/ingredients");

         $ingredientModel = new IngredientModel($this->pdo);
         $id = isset($_POST['id']) ? trim($_POST['id']) : null;

        $ingredient = $ingredientModel->findById($id);

        if(!$ingredient) {
            Flash::set("L'ingrédient n'existe pas!", "secondary");
            header("Location: /admin/ingredients");
            exit;
        }

        try {
            
            $ingredientModel->delete($id);
            Flash::set("Suppression réussie", "primary");
            
        } catch(Exception $e) {
            error_log($e->getMessage());
            Flash::set("Erreur dans la suppression", "secondary");
            exit;
        }

        header("Location: /admin/ingredients");
        exit;

    }

    public function createIngredient(array $data) {
         
        session_start();
        Auth::isAdmin();

        $token = $data['_token'];
        Csrf::check("create_ingredient", $token, "/admin/ingredients");

        if (!isset($data['name']) || empty(trim($data['name']))) {
            Flash::setErrorsForm("name", "Le nom est obligatoire.");
            header("Location: /admin/ingredients");
            exit;
        }

        $name = trim($data['name']);

        $ingredientModel = new IngredientModel($this->pdo);
        $ingredientName = $ingredientModel->getIngredientName($name);

        if($ingredientName) {
            Flash::set("L'ingrédient existe déja.", "secondary");
            header("Location: /admin/ingredients");
            exit;
        }

        if(!isset($data["type"]) || empty($data["type"])) {
            Flash::set("Type obligatoire.", "secondary");
            header("Location: /admin/ingredients");
            exit;
        }

        $type = $data['type'];

        $allowedTypes = ['fruits', 'sauces', 'legumes', 'viandes', 'cereales', 'legumineuses', 'poissons', 'oeufs', 'laitier', 'huiles', 'sucres'];
        
        if (!in_array($type, $allowedTypes, true)) {
                Flash::set("Type invalide.", "secondary");
                header("Location: /admin/ingredients");
                exit;
            }
        
         try {
                $ingredientModel->insert(["name" => $name, "type" => $type]);
                Flash::set("Ingrédient ajouté", "primary");

         } catch(Exception $e) {
                error_log($e->getMessage());
                Flash::set("Erreur dans la création de l'ingrédient", "secondary");
                exit;
         }

         header("Location: /admin/ingredients");
         exit;
        
    }
}