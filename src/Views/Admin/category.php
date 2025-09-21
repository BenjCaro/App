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
    <h1 class="text-center"><?= ucfirst($category['name']) ?></h1>
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
    <section class="row d-flex justify-content-center">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th>Date</th>
                        <th>Titre</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                     <?php if(!empty($recipes)) {
                     foreach($recipes as $recipe) {  ?>
                        <tr>
                            <td><?= htmlspecialchars($recipe->getCreatedAt()) ?></td>
                            <td><?= htmlspecialchars($recipe->getTitle()) ?></td>
                            <td><a href="/recette/<?= urlencode($recipe->getSlug()) ?>">Voir recette</a></td>
                        </tr>
                        
                     <?php   }} ?> 
                    
                </tbody>
            </table>
        </div>
    </section>
</main>