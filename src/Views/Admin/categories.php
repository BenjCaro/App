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
    <h1 class="text-center">Catégories</h1>
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
        <h2 class="text-center">Catégories existantes</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th>Nom</th>
                        <th>Icône</th>
                        <th>Nombre de recettes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                     <?php if(!empty($categories)) {
                     foreach($categories as $category) {  ?>
                        <tr>
                            <td><?= htmlspecialchars($category->getName()) ?></td>
                            <td><img class="icone" alt="icone <?=$category->getName(); ?>" src="/assets/images/categories/<?= $category->getImage();?>"/></td>
                            <td><?= $category->getTotalRecipes() ?></td>
                            <td><a href="/admin/categories/<?= $category->getSlug() ?>">Voir la catégorie</a></td>
                        </tr>
                        
                     <?php   }} ?> 
                    
                </tbody>
            </table>
        </div>
    </section>
    <section class="row d-flex flex-column align-items-center justify-content-center gap-2">
        <h2 class="text-center">Créer une catégorie</h2>
        <form action="/admin/newCategory" class="bg-gris card col-6" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="">
                <div class="card-body">
                    <div class="mb-2">
                        <label for="">Nom de la catégorie</label>
                        <input class="form-control" type="text" name="name" value="" required>
                    </div>
                    <div class="mb-2">
                        <label for="formFile" class="form-label">Ajouter un icone au format .svg</label>
                        <input class="form-control" type="file" id="formFile" name="image" required>
                    </div>
                    <div class="d-flex justify-content-center mb-2 gap-2">
                        <button type="submit" id="" class="btn btn-sm btn-primary">Valider la création</button>
                    </div>
                </div>
        </form>
    </section>
</main>