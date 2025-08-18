<?php

namespace Carbe\App\Controllers;
use Carbe\App\Models\PostModel;
use Carbe\App\Models\RecipeModel;
use Exception;

use function Carbe\App\Services\isAuth;

class PostController extends BaseController {

    public function showComment(int $id) :void {

        session_start();

        if (!isset($_SESSION['auth_user'])) {
            $_SESSION['flash'] = "Connectez-vous pour accèder à cette page!";
            header('Location: /login');
            exit();
    }

        $postModel = new PostModel($this->pdo);
        $post = $postModel->getCommentById($id);

        $this->render('Users/post', [
            'title' => "Petit Creux | Mon Compte",
            'post'=> $post
        ]);


    }

   public function addComments($slug) :void {
    session_start();
    isAuth();

    $userId = $_SESSION['auth_user']['id'];
    
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    
    if (empty($title) || empty($content)) {
        $_SESSION['errors'] = "Veuillez remplir les champs pour commenter la recette !";
        return;
    }

    $recipeModel = new RecipeModel($this->pdo);
    $recipe = $recipeModel->getRecipeBySlug($slug);

    if (!$recipe) {
        $_SESSION['errors'] = "Recette introuvable.";
        header("Location: /");
        exit;
    }

    $commentData = [
        'id_user' => $userId,
        'id_recipe' => $recipe->getId(),
        'title' => $title,
        'content' => $content
    ];

    try {
        $post = new PostModel($this->pdo);
        $post->insert($commentData);

        $_SESSION['flash'] = "Commentaire ajouté avec succès !";
    } catch(Exception $e) {
        
        // error_log
        $_SESSION['errors'] ="Commentaire non soumis.";
    }
   
}

public function updateComment(int $id) :void {
    
    session_start();
    isAuth();
    $post = new PostModel($this->pdo);
    $post->findById($id);

    $this->checkUser($post->getIdUser());

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // vérifier que id_user et id_recipe correspondent avec le commentaire à modifier
    // avant de soumettre la req SQL de modification

    try {

        $post = new PostModel($this->pdo);
        $post->update($id, [
        'title' => $title,
        'content' => $content
    ]);  

        $_SESSION['flash'] = "Commentaire modifié avec succés !";
        header("Location: /mes-commentaires/commentaire-$id");

        exit();

    } catch(Exception $e) {

        $_SESSION['errors'] ="Commentaire non modifié.";

    }

    
}

public function deleteComment(int $id) {
    
    session_start();
    isAuth();
    $post = new PostModel($this->pdo);
    $post->findById($id);

    $this->checkUser($post->getIdUser());

    try {

        $post = new PostModel($this->pdo);
        $post->setId($id);
        $post->delete();

        $_SESSION['flash'] = "Commentaire supprimé avec succés !";
        header("Location: /mon-compte");
        exit;


    } catch(Exception $e) {

        $_SESSION['errors'] = "Le commentaire n'a pas ete supprimé!";
        header("Location: /mon-compte");



    }

}


}