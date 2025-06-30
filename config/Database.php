<?php

namespace Carbe\App\config;

use Exception;
use PDO;


/**
 *  classe Database destinée à gérer la connexion à la BDD 
 *  25/06/25 : mise en place d'une connexion à une base de test avec 'root'
 */
class Database {

  public function connectDB() {

    $user = 'root';
    $pass = '';

        try {
          return  $dbh = new PDO('mysql:host=localhost;dbname=db_test', $user, $pass);
            // error_log('Connexion à la base réussie');

        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

}
