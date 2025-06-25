<?php

namespace Carbe\App\config;

use Exception;
use PDO;

class Database {

  public function connectDB() {

    $user = 'root';
    $pass = '';

        try {
            $dbh = new PDO('mysql:host=localhost;dbname=db_test', $user, $pass);
            error_log('Connexion à la base réussie');

        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

}
