<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use PDO;

class FavorisModel extends BaseModel {

    protected string $table = "favoris";

    private int $idUser; 
    private int $idRecipe;

/**
 * @param array<string, mixed> $data
 */
public function __construct(PDO $pdo, array $data = [])
    {
        parent::__construct($pdo);
       
      if (!empty($data)) {
            $this->hydrate($data);
      }
    }

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

public function ifFavorisExist(int $idUser, int $idRecipe) :bool {
     $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM favoris where favoris.id_user = :id_user and favoris.id_recipe = :id_recipe");
     $stmt->execute([
        'id_user' => $idUser,
        'id_recipe' => $idRecipe
    ]);
    return $stmt->fetchColumn() > 0;  // retourne true si > 0 donc favoris deja existant


}

}

