<?php

namespace Carbe\App\Controllers;
use Carbe\App\Models\PostModel;
use Carbe\App\Models\RecipeModel;
use Exception;
use Carbe\App\Services\Flash;
use Carbe\App\Services\Auth;
use Carbe\App\Services\Csrf;


class PostController extends BaseController {

    public function showComment(int $id) :void {

        session_start();

        Auth::isAuth();
            
        $postModel = new PostModel($this->pdo);
        $post = $postModel->getCommentById($id);

        $this->render('Users/post', [
            'title' => "Petit Creux | Mon Compte",
            'post'=> $post
        ]);


    }

/**
 * @param string $slug
 * 
 * 
 */


   public function addComments($slug) :void {
    session_start();
    Auth::isAuth();

    $userId = $_SESSION['auth_user']['id'];
    
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $token = $_POST['_token'];
    
    if (empty($title) || empty($content)) {
        $_SESSION['errors'] = "Veuillez remplir les champs pour commenter la recette !";
        return;
    }

    $recipeModel = new RecipeModel($this->pdo);
    $recipe = $recipeModel->getRecipeBySlug($slug);

    if ($recipe === null) {
        $_SESSION['errors'] = "Recette introuvable.";
        header("Location: /");
        exit;
    }

    Csrf::check("add_comment", $token, "/recette/$slug");

    $commentData = [
        'id_user' => $userId,
        'id_recipe' => $recipe->getId(),
        'title' => $title,
        'content' => $content
    ];

    try {
        $post = new PostModel($this->pdo);
        $post->insert($commentData);

       // $_SESSION['flash'] = "Commentaire ajouté avec succès !";
        Flash::set("Commentaire ajouté avec succès !", "primary");
    } catch(Exception $e) {
        
        // error_log
        $_SESSION['errors'] ="Commentaire non soumis.";
    }
   
}

public function updateComment(int $id) :void {
    
    session_start();
    Auth::isAuth();
    $post = (new PostModel($this->pdo))->findById($id);


    $this->checkUser($post->getIdUser());

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $token = $_POST['_token'];

    Csrf::check("update_post", $token, "/mes-commentaires/commentaire-$id");

    try {

        $post = new PostModel($this->pdo);
        $post->update($id, [
        'title' => $title,
        'content' => $content
    ]);  

        Flash::set("Commentaire modifié avec succés !", "primary");
        header("Location: /mes-commentaires/commentaire-$id");

        exit();

    } catch(Exception $e) {

        $_SESSION['errors'] ="Commentaire non modifié.";

    }
    
}

public function deleteComment(int $id) :void {
    
    session_start();
    Auth::isAuth();
    $post = (new PostModel($this->pdo))->findById($id);

    $this->checkUser($post->getIdUser());

    try {

        $post = new PostModel($this->pdo);
        $post->delete($id);

        Flash::set("Commentaire supprimé avec succés !", "primary");
        header("Location: /mon-compte");
        exit;


    } catch(Exception $e) {

        $_SESSION['errors'] = "Le commentaire n'a pas ete supprimé!";
        header("Location: /mon-compte");

    }

}


}