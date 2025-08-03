<?php

namespace Carbe\App\Controllers;
use Carbe\App\Models\PostModel;
use Exception;

class PostController extends BaseController {

   public function addComments(array $data) {
    session_start();

    $userId = $data['id_user'];
    $recipeId = $data['id_recipe'];
    $title = trim($data['title']);
    $content = trim($data['content']);

    
    if (empty($title) || empty($content)) {
        $_SESSION['errors'] = "Veuillez remplir les champs pour commenter la recette !";
        return;
    }

    $commentData = [
        'id_user' => $userId,
        'id_recipe' => $recipeId,
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