<?php

namespace Carbe\App\Views\Admin;

?>

<main class='container p-3 bg-light'>
    <h1 class="text-center">Bienvenue <?= htmlspecialchars($admin->getName()) ?></h1>
    <section class="row d-flex justify-content-center">
        <h3 class="text-center mt-4 mb-4">Derniers Utilisateurs</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Membre depuis</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($users)) {
                     foreach($users as $user) {  ?>
                        <tr>
                            <td><?= htmlspecialchars($user->getName()) ?></td>
                            <td><?= htmlspecialchars($user->getFirstName()) ?></td>
                            <td><?= htmlspecialchars($user->getEmail()) ?></td>
                            <td><?= htmlspecialchars($user->getCreatedAt()) ?></td>
                            <td><a href="/admin/profil/utilisateur-<?= $user->getId() ?>">Voir plus</a></td>  
                        </tr>
                        
                     <?php   }} ?>
                    
                </tbody>
            </table>
        </div>
    </section>
    <section class="row d-flex justify-content-center">
        <h3 class="text-center mt-4 mb-4">Dernieres Recettes</h3>
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
    <section class="row d-flex justify-content-center">
        <h3 class="text-center mt-4 mb-4">Derniers Commentaires</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Rédacteur</th>
                        <th>Recette</th>
                        <th>Titre commentaire</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($posts as $post) { ?>
                    <tr>
                        <td><?= htmlspecialchars($post->getCreatedAt())?></td>
                        <td><?= htmlspecialchars($post->getAuthor()->getName()) . ' ' . htmlspecialchars($post->getAuthor()->getFirstname()) ?></td>
                        <td><?= htmlspecialchars($post->getRecipe()->getTitle()) ?></td>
                        <td><?= htmlspecialchars($post->getTitle()) ?></td>
                        <td><a href="/recette/<?= urlencode($post->getRecipe()->getSlug())?>#post-<?=$post->getId() ?>">Voir commentaire</a></td>
                    </tr>
                 <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</main>