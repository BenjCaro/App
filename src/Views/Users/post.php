<?php 

namespace Carbe\App\Views\Users;
?>

<main class="container p-3 bg-light">
    <?php
     if (isset($_SESSION['flash'])) {  ?>
       <div class='alert alert-primary'><?=$_SESSION['flash']?></div>
    <?php    unset($_SESSION['flash']); 
    }


    if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) { ?>
    <div class="alert alert-secondary">
    <?php foreach ($_SESSION['errors'] as $error) { ?>
            <?= htmlspecialchars($error) ?>
    <?php } ?>
            
    </div>
        <?php unset($_SESSION['errors']); 
    }

    ?>
    <div class="d-flex justify-content-center">
        <form action="/mes-commentaires/commentaire-<?=htmlspecialchars($post->getId())?>" method="post" id="formPostEdit" class="card col-12 col-md-8 col-lg-6 p-4 shadow">

            <div class="mb-3">
                <label for="title" class="form-label">Titre du commentaire</label>
                <input class="form-control bg-gris" type="text" id="title" name="title" value="<?= htmlspecialchars($post->getTitle()) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Contenu</label>
                <textarea class="form-control bg-gris" name="content" id="content" rows="8" readonly><?= htmlspecialchars($post->getContent()) ?></textarea>
            </div>
            <div id="formDiv" class="d-flex justify-content-center gap-2">
                <button type="button" id="editPost" class="btn btn-sm btn-primary">Modifier votre commentaire</button>
            </div>
        </form>
    </div>
    <div class="d-flex justify-content-center">
        <form id="formDelete" action="/mes-commentaires/suppr/commentaire-<?=htmlspecialchars($post->getId())?>" method="POST" class="card col-12 col-md-8 col-lg-6 p-4 shadow">
             <button type="submit" class="btn btn-sm btn-secondary">Supprimer votre commentaire</button>
        </form>
    </div>
</main>
<script src="/assets/scripts/editing.js" type="text/javascript"></script>
<script>
    const btn = document.getElementById('editPost');
    const formEdit = document.getElementById('formPostEdit');
    const title = document.getElementById('title');
    const OriginalTitle = title.value;
    const content = document.getElementById('content');
    const OriginalContent = content.value;
    const div = document.getElementById('formDiv');
   

    edit(formEdit, [title, content], btn);

    const formDelete = document.getElementById('formDelete');
    formDelete.addEventListener("submit", (event) => {
        event.preventDefault();
        
        if(confirm('Êtes vous sur de supprimer votre commentaire?')) {
            
            formDelete.submit();
        } 
    });

</script>