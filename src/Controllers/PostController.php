<?php

namespace Carbe\App\Controllers;
use Carbe\App\Models\PostModel;
use Carbe\App\Models\RecipeModel;
use Exception;

class PostController extends BaseController {

    public function showComment(int $id) {

        $postModel = new PostModel($this->pdo);
        $post = $postModel->getCommentById($id);

        $this->render('Users/post', [
            'title' => "Petit Creux | Mon Compte",
            'post'=> $post
        ]);


    }

   public function addComments($slug) {
    session_start();

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
   
}}