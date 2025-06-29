<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use PDO;

class RecipeModel extends BaseModel {

   protected string $table = 'recipes';

    private string $title;
    private string $slug;
    private int $idUser;
    private int $idCategory;
    private string $createdAt;
    private int $duration;
    private string $content;

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
     return $this->content;
  }

  public function setDescription(string $content) :void {
    $this->content = $content;
  }


}
