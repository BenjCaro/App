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
 * @param array<string, mixed> $data
 */


    protected function render(string $view, array $data = []) :void {

        extract($data);
        require_once VIEW_PATH . '/Partials/header.php';
        require_once VIEW_PATH . '/Partials/banniere.php';
        require_once VIEW_PATH . '/' . $view . '.php';

        require_once VIEW_PATH . '/Partials/footer.php';

    }
}