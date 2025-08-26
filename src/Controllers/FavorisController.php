<?php
namespace Carbe\App\Controllers;

use Carbe\App\Models\FavorisModel;
use Carbe\App\Services\Auth;
use Carbe\App\Services\Flash;


class FavorisController extends BaseController {

    private FavorisModel $favorisModel;

    public function __construct()
    {   
        parent::__construct();
        $this->favorisModel = new FavorisModel($this->pdo);
        
    }

   public function insert(int $idUser, int $idRecipe): void
    {
    session_start();

    Auth::isAuth();

    if(!$this->favorisModel->ifFavorisExist($idUser, $idRecipe)) {
         $this->favorisModel->insert([
            'id_user' => $idUser,
            'id_recipe' => $idRecipe
        ]);
    
       
        Flash::set("Ajout aux favoris réussis", "primary");
        
    } else {
       
        Flash::set("Recette deja ajoutée aux favoris", "primary");
    }
    

    }

   public function delete(int $idUser, int $idRecipe):void {
        
        session_start();
        Auth::isAuth();
        $idUser = $_SESSION['auth_user']['id'];
        $this->checkUser($idUser);
        
        $this->favorisModel->removeFavoris($idUser,$idRecipe);
        $_SESSION['flash'] = "Recette supprimée des favoris";
        header('Location: /mon-compte');
        exit();
    }
}
?>