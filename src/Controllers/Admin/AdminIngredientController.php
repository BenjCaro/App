<?php 

namespace Carbe\App\Controllers\Admin;

use Carbe\App\Controllers\BaseController;
use Carbe\App\Services\Auth;
use Carbe\App\Models\IngredientModel;
use Carbe\App\Services\Csrf;
use Carbe\App\Services\Flash;
use Exception;
use PhpParser\Node\Expr;

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
}