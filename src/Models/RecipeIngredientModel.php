<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use Carbe\App\Models\IngredientModel;
use PDO;

class RecipeIngredientModel extends BaseModel {

    protected string $table= "recipes_ingredients";
    
    private int $quantity;
    private string $unit;
    private IngredientModel $ingredient;

/**
 * @param array<string, mixed> $data
 */

    public function __construct(PDO $pdo, array $data = []) {
        parent::__construct($pdo);
       
      if (!empty($data)) {
            $this->hydrate($data);
      }
    }

    public function setIngredient(IngredientModel $ingredient): void {
    $this->ingredient = $ingredient;
    
    }


    public function getIngredient(): IngredientModel {
        return $this->ingredient;
    }

    public function getQuantity() :int {
        return $this->quantity;
    }

    public function setQuantity(int $quantity) :void {
            $this->quantity = $quantity;
    }

    public function getUnit() :string {
        return $this->unit;
    }

    public function setUnit(?string $unit) :void {
        $this->unit = $unit ?? '';
    }



}