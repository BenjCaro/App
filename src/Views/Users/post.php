<?php 

namespace Carbe\App\Views\Users;

?>

<main class="container p-3 bg-light border-start border-end border-secondary  d-flex justify-content-center align-items-center">
    <form action="" class="card col-12 col-md-8 col-lg-6 p-4 shadow">
        <input type="hidden" name="id" value="<?= htmlspecialchars($post->getId()) ?>">
        
        <div class="mb-3">
            <label for="title" class="form-label">Titre du commentaire</label>
            <input class="form-control bg-gris" type="text" id="title" name="title" value="<?= htmlspecialchars($post->getTitle()) ?>" readonly>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Contenu</label>
            <textarea class="form-control bg-gris" name="content" id="content" rows="8" readonly><?= htmlspecialchars($post->getContent()) ?></textarea>
        </div>
    </form>
</main>
