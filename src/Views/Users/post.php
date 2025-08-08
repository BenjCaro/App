<?php 

namespace Carbe\App\Views\Users;

?>

<main class="container p-3 bg-light border-start border-end border-secondary  d-flex justify-content-center align-items-center">
    <form action="/mes-commentaires/commentaire-<?=htmlspecialchars($post->getId())?>" method="post" id="formPostEdit" class="card col-12 col-md-8 col-lg-6 p-4 shadow">

        <div class="mb-3">
            <label for="title" class="form-label">Titre du commentaire</label>
            <input class="form-control bg-gris" type="text" id="title" name="title" value="<?= htmlspecialchars($post->getTitle()) ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Contenu</label>
            <textarea class="form-control bg-gris" name="content" id="content" rows="8" readonly><?= htmlspecialchars($post->getContent()) ?></textarea>
        </div>
        <div class="d-flex justify-content-center">
            <button type="button" id="editPost" class="btn btn-sm btn-primary">Modifier votre commentaire</button>
        </div>
    </form>
</main>
<script>
    const btn = document.getElementById('editPost');
    const form = document.getElementById('formPostEdit');
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
         form.requestSubmit();

       }

    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        if(confirm('Etes vous sur de valider vos modifications?')) {

                form.submit();

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


</script>