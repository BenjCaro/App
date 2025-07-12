<?php
namespace Carbe\App\Controllers;

use Carbe\App\Models\FavorisModel;


class FavorisController extends BaseController {

    private FavorisModel $favorisModel;

    public function __construct()
    {   
        parent::__construct();
        $this->favorisModel = new FavorisModel($this->pdo);
        
    }

   public function insert(int $idUser, int $idRecipe): void
{

    $_SESSION['flash'] = "Ajout aux favoris réussis";
    $this->favorisModel->insert([
        'id_user' => $idUser,
        'id_recipe' => $idRecipe
    ]);
}
}
?>