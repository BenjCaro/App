<?php 

namespace Carbe\App\Models;
use Carbe\App\Models\BaseModel;
use PDO;

class PostModel extends BaseModel {
   protected string $table = 'posts';

   private string $title;
   private string $content;
   private int $UserId;
   private int $RecipeId;
   private $createdAt;
   private bool $isApproved = false;

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
   
    public function getContent() :string {
    return $this->content;
   }

   public function setContent(string $content) :void {
    $this->title = $content;
   }

   public function getCreatedAt() :string {
    return $this->createdAt;
  }

  public function getIsApproved() :bool {
    return $this->isApproved;
  }

  public function setIsApproved(bool $isApproved) :void {
    $this->isApproved = $isApproved;
    
  }

  public function approve(): void {
    $this->isApproved = true;
}
}