<?php
namespace Carbe\App\Views\Admin;
use Carbe\App\Services\Flash;

?>

<main class='container p-3 bg-light'> 
    <?php
     $messages = Flash::get();
     foreach($messages as $message) { ?>
        <div class="alert alert-<?= $message['type'] ?>"><?= $message['message']?></div>
    <?php }
    ?>
    <h1 class="text-center">Recettes</h1>
    <section class="mb-4 d-flex justify-content-center">
        <form method="get" action="" class="w-50">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Rechercher une recette" name="q" required>
                <button class="btn btn-primary" type="submit">🔍</button>
            </div>
        </form>
   </section>
   <section class="row d-flex justify-content-center">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Createur</th>
                        <th>Catégorie</th>
                        <th>Titre</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($recipes as $recipe) { ?>
                    <tr>
                        <td><?= htmlspecialchars($recipe->getUser()->getName()) . ' ' .htmlspecialchars($recipe->getUser()->getFirstname()) ?></td>
                        <td><?= htmlspecialchars($recipe->getCategory()->getName()) ?></td>
                        <td><?= htmlspecialchars($recipe->getTitle()) ?></td>
                        <td><a href="/recette/<?= urlencode($recipe->getSlug()) ?>">Voir recette</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</main>