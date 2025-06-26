<?php 

namespace Carbe\App\Models;

use PDO;

class BaseModel {

    protected PDO $pdo;
    protected string $table;

 

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getById(int $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;

    }

    public function findAll() {
         $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
         $stmt->execute();
         return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function insert() {
        // "INSERT INTO {$this->table} " insert() pour insérer des données dynamiques 
        // passer d'un tableau à une chaine 

    }   
    

}