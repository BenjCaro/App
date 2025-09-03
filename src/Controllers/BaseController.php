<?php

namespace Carbe\App\Controllers;
use Carbe\App\config\Database;
use PDO;

class BaseController {

    protected PDO $pdo;
    
     public function __construct()
     {
          $bdd = new Database();
          $this->pdo = $bdd->connectDB();
     }

 /**
 * 
 * @param array<string, mixed> $data
 */


    protected function render(string $view, array $data = []) :void {

        extract($data);
        require_once VIEW_PATH . '/Partials/header.php';
        require_once VIEW_PATH . '/Partials/banniere.php';
        
        $adminView = VIEW_PATH . '/Admin/' . $view . '.php';
        $mainView  = VIEW_PATH . '/' . $view . '.php';

        if (file_exists($adminView)) {
            require_once $adminView;
        } elseif (file_exists($mainView)) {
            require_once $mainView;
        } else {
            
            die("Vue introuvable : " . $view);
        }

        require_once VIEW_PATH . '/Partials/footer.php';

    }

/** 
*  
* Methode permettant de s'assurer que l'id de l'utilisateur connecté correspond à l'id utilisateur créateur de la recette,
* d'un commentaire. 
* Utile pour contrôler si l'utilisateur est habilité à des actions CRUD.
*/

    protected function checkUser(int $resourceOwnerId): void {
    session_start();

    if ($resourceOwnerId !== $_SESSION['auth_user']['id']) {
        $_SESSION['errors'][] = "Action non autorisée.";
        header('Location: /mon-compte');
        exit;
    }
}

}