<?php 

namespace Carbe\App\Models;

use PDO;

class BaseModel {

    protected PDO $pdo;
    protected int $id;
    protected string $table;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }


      public function getId() : int {
        return $this->id;
    }

    public function findById(int $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $this->getId()]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;

    }

    public function findAll() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function insert(array $data) {
        $array = array_keys($data);
        $columns = implode( ", " , $array);
        $values = ':' . implode(', :', $array);

        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($columns) VALUES ($values)"); 
        $stmt->execute($data);

    }   

    public function hydrate(array $data): void {

        foreach ($data as $key => $value) {
            $camelCaseKey = lcfirst(str_replace('_', '', ucwords($key, '_')));
            $method = 'set' . ucfirst($camelCaseKey);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function delete() : bool { // supprimer une donnée (ex: un utilisateur, une recette, un commentaire, etc...)

        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} where id = :id");
       
        return $stmt->execute(['id' => $this->getId()]);
    }

    

}

