<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use PDO;

class FavorisModel extends BaseModel {

    protected string $table = "favoris";

    private int $idUser; 
    private int $idRecipe;

    public function getIdUser(): int {
    return $this->idUser;
}

public function setIdUser(int $idUser): void {
    $this->idUser = $idUser;
}

public function getIdRecipe(): int {
    return $this->idRecipe;
}

public function setIdRecipe(int $idRecipe): void {
    $this->idRecipe = $idRecipe;
}


    public function __construct(PDO $pdo, array $data = [])
    {
        parent::__construct($pdo);
       
      if (!empty($data)) {
            $this->hydrate($data);
      }
    }

    public function addToFavoris(int $idUser, int $idRecipe) :bool {

        $stmt = $this->pdo->prepare("INSERT INTO favoris (id_user, id_recipe) VALUES (:id_user, :id_recipe)");
        return $stmt->execute([

            'id_user' => $idUser,
            'id_recipe' => $idRecipe  
        ]);

    }

    public function removeToFavoris(int $idUser, int $idRecipe) :bool {
        
        $stmt = $this->pdo->prepare("DELETE FROM favoris WHERE id_user = :id_user AND id_recipe = :id_recipe");
        return $stmt->execute([

            'id_user' => $idUser,
            'id_recipe' => $idRecipe  
        ]);
    }

}

