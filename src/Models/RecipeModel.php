<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use PDO;

class RecipeModel extends BaseModel {

    private string $title;
    private string $slug;
    private int $UserId;
    private int $CategoryId;
    private string $createdAt;
    private int $duration;
    private string $description;

    public function __construct(PDO $pdo, array $data = [])
    {
        parent::__construct($pdo);
       
      if (!empty($data)) {
            $this->hydrate($data);
      }
    }

    public function getTitle() :string {
        return $this->title;
   }

   public function setTitle(string $title) :void {
    $this->title = $title;
   }

   public function getSlug() : string {
     return $this->slug;
  }

  public function setSlug(string $slug) : void {
     $this->slug = $slug;
  }

  public function getCreatedAt() :string {
    return $this->createdAt;
  }

  public function getDuration() :int {
     return $this->duration;

  }

  public function setDuration(int $duration) :void {
     $this->duration = $duration;
  }

  public function getDescription() :string {
     return $this->description;
  }

  public function setDescription(string $description) :void {
    $this->description = $description;
  }


}
