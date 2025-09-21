<?php

namespace Carbe\App\Views\Admin;
use Carbe\App\Services\Flash;
use Carbe\App\Services\Csrf;

?>

<main class='container p-3 bg-light'> 
     <?php
     $messages = Flash::get();
     foreach($messages as $message) { ?>
        <div class="alert alert-<?= $message['type'] ?>"><?= $message['message']?></div>
    <?php }
    ?>
    <h1 class="text-center"><?= ucfirst($category->getName()) ?></h1>
    <section class="mb-4 d-flex justify-content-center">
        <form method="get" action="/admin/search" class="w-50">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Recherche" name="q" required>
                <select class="form-select" name="type">
                    <option value="category">Catégorie</option>
                    <option value="user">Utilisateur</option>
                    <option value="recipe">Recette</option>
                </select>
                <button class="btn btn-primary" type="submit">🔍</button>
            </div>
        </form>
   </section>
   <section class="row d-flex flex-column align-items-center justify-content-center gap-2 mb-2">
          <form class="card col-6" id="" action="" method="POST">
            <?php $token = Csrf::get("admin_update_category");  ?>
            <input type="hidden" name="_token" value="<?= $token ?>">
            <div class="card-body">
                <div class="mb-2">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" id="name" name="name" class="form-control bg-gris" value="<?= $category->getName(); ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control bg-gris" name="slug" id="slug" value="<?= $category->getSlug(); ?>" readonly>
                </div>
                 <div class="d-flex justify-content-center mb-2 gap-2">
                    <button type="button" id="editInformation" class="btn btn-sm btn-primary">Modifier les informations</button>
                    <button type="submit" id="hiddenSubmit" class="d-none"></button>
                </div>
            </div>    
        </form>
        <form action="/admin/suppression-categorie-<?= $category->getId()?>" method="POST" class="card col-12 col-md-8 col-lg-6 p-4 shadow">
            <!-- afficher un msg de confirmation avant suppression -->
            <button type="submit" class="btn btn-sm btn-secondary">Supprimer la catégorie</button>
        </form>
   </section>
    <section class="row d-flex justify-content-center">
        <h2 class="text-center">Toutes les recettes de la catégorie:</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th>Date</th>
                        <th>Titre</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                     <?php if(!empty($recipes)) {
                     foreach($recipes as $recipe) {  ?>
                        <tr>
                            <td><?= htmlspecialchars($recipe->getCreatedAt()) ?></td>
                            <td><?= htmlspecialchars($recipe->getTitle()) ?></td>
                            <td><?= htmlspecialchars($recipe->getState())?></td>
                            <td><a href="/recette/<?= urlencode($recipe->getSlug()) ?>">Voir recette</a></td>
                        </tr>
                        
                     <?php   }} ?> 
                    
                </tbody>
            </table>
        </div>
    </section>
</main>