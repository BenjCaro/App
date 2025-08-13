<?php
namespace Carbe\App\Controllers;

use Carbe\App\Models\FavorisModel;
use function Carbe\App\Services\isAuth;


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

    isAuth();

    if(!$this->favorisModel->ifFavorisExist($idUser, $idRecipe)) {
         $this->favorisModel->insert([
            'id_user' => $idUser,
            'id_recipe' => $idRecipe
        ]);
    
        $_SESSION['flash'] = "Ajout aux favoris réussis";
        
    } else {
        $_SESSION['flash'] = "Recette deja ajoutée aux favoris";
    }
    

    }

   public function delete(int $idUser, int $idRecipe):void {
        
        session_start();
        isAuth();
        $idUser = $_SESSION['auth_user']['id'];
        $this->checkUser($idUser);
        
        $this->favorisModel->removeFavoris($idUser,$idRecipe);
        $_SESSION['flash'] = "Recette supprimée des favoris";
    }
}
?>