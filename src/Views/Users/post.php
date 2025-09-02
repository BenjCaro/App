<?php 

namespace Carbe\App\Views\Users;
use Carbe\App\Services\Flash;
use Carbe\App\Models\PostModel;
use Carbe\App\Services\Csrf;

/** @var \Carbe\App\Models\PostModel $post */
?>


<main class="container p-3 bg-light">
  <?php
     $messages = Flash::get();
     foreach($messages as $message) { ?>
        <div class="alert alert-<?= $message['type'] ?>"><?= $message['message']?></div>
    <?php }
    
    if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) { ?>
    <div class="alert alert-secondary">
    <?php foreach ($_SESSION['errors'] as $error) { ?>
            <?= htmlspecialchars($error) ?>
    <?php } ?>
            
    </div>
        <?php unset($_SESSION['errors']); 
    }

    ?>
    <h2 class="text-center">Recette : <?= $post->getRecipe()->getTitle() ?></h2>
    <div class="d-flex justify-content-center">
        <form action="/mes-commentaires/commentaire-<?=htmlspecialchars(strval($post->getId()))?>" method="post" id="formPostEdit" class="card col-12 col-md-8 col-lg-6 p-4 shadow">
            <?php $token = Csrf::get("update_post");  ?>
            <input type="hidden" name="_token" value="<?= $token ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Titre du commentaire</label>
                <input class="form-control bg-gris" type="text" id="title" name="title" value="<?= htmlspecialchars($post->getTitle()) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Contenu</label>
                <textarea class="form-control bg-gris" name="content" id="content" rows="8" readonly><?= htmlspecialchars($post->getContent()) ?></textarea>
            </div>
            <div id="formDiv" class="d-flex justify-content-center mb-2 gap-2">
                <button type="button" id="editPost" class="btn btn-sm btn-primary">Modifier votre commentaire</button>
                <button type="submit" id="hiddenSubmit" class="d-none"></button>
            </div>
            <div class="mt-1">
                Posté le : <?= htmlspecialchars($post->getCreatedAt()) ?>
            </div>
        </form>
    </div>
    <div class="d-flex justify-content-center">
        <form id="formDelete" action="/mes-commentaires/suppr/commentaire-<?=$post->getId()?>" method="POST" class="card col-12 col-md-8 col-lg-6 p-4 shadow">
            <button type="submit" class="btn btn-sm btn-secondary">Supprimer votre commentaire</button>
        </form>
    </div>
</main>

<script type="module" src="/assets/scripts/updateComment.js"></script>
<script type="text/javascript" src="/assets/scripts/deleteComment.js"></script>
