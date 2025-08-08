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
            <div class="d-flex justify-content-center gap-2">
                <button type="button" id="editPost" class="btn btn-sm btn-primary">Modifier votre commentaire</button>
                <button type="button" id="showForm" class="btn btn-sm btn-secondary">Supprimer votre commentaire</button>
            </div>
        </form>
    </div>
    <div id="deletePost" class="d-flex justify-content-center"></div>
</main>
<script>
    const btn = document.getElementById('editPost');
    const formEdit = document.getElementById('formPostEdit');
    const title = document.getElementById('title');
    const content = document.getElementById('content');
    let editing = false;

    btn.addEventListener('click', (event) => {
       event.preventDefault();
        
       if(!editing) {

          editing = true;
          btn.textContent = "Confirmez les modifications";
          btn.classList.replace("btn-primary", "btn-secondary");
          title.removeAttribute("readonly");
          title.classList.remove("bg-gris");
          content.removeAttribute("readonly");
          content.classList.remove("bg-gris");

       } else { 
         formEdit.requestSubmit();

       }

    });

    formEdit.addEventListener('submit', (event) => {
        event.preventDefault();
        if(confirm('Etes vous sur de valider vos modifications?')) {

                formEdit.submit();

        } else {

            editing = false;
            btn.textContent = "Modifier mon commentaire";
            btn.classList.replace("btn-secondary", "btn-primary");
            title.setAttribute("readonly", true);
            title.classList.add("bg-gris");
            content.setAttribute("readonly", true);
            content.classList.add("bg-gris");
        }
    });

    const id = <?=json_encode($post->getId()) ?>;
    const div = document.getElementById('deletePost');
    const showForm = document.getElementById("showBtn")

    const formDelete = document.createElement('form');
    formDelete.action = `/mes-commentaires/suppr/commentaire-${id}`;
    formDelete.method = "post";
    formDelete.classList.add("card", "col-12", "col-md-8", "col-lg-6" ,"p-4" ,"shadow");

    const btnDelete = document.createElement('button');
    btnDelete.classList.add("btn", "btn-secondary");
    btnDelete.textContent = "Supprimer le commentaire";
    btnDelete.type = "submit";

    formDelete.appendChild(btnDelete);
    div.appendChild(formDelete);

    formDelete.addEventListener("submit", (event) => {
        
        if(confirm('Êtes vous sur de supprimer votre commentaire?')) {
            
            formDelete.requestSubmit();
        } 
    })




</script>