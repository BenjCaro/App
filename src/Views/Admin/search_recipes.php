<?php

namespace Carbe\App\Views\Admin; ?>

<section class="row d-flex justify-content-center">
    <h1 class="text-center">Résultat(s)</h1>
     <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Crée le</th>
                    <th>Createur</th>
                    <th>Catégorie</th>
                    <th>Titre</th>
                    <th>Etat</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  <?php if(!empty($results)) {
                    foreach($results as $recipe) {  ?>
                        <tr>
                            <td><?= htmlspecialchars($recipe->getCreatedAt()) ?></td>
                            <td><?= htmlspecialchars($recipe->getUser()->getName()) ?></td>
                            <td><?= htmlspecialchars($recipe->getCategory()->getName()) ?></td>
                            <td><?= htmlspecialchars($recipe->getTitle()) ?></td>
                            <td><?= htmlspecialchars($recipe->getState()) ?></td>
                            <td><a href="/recette/<?= urlencode($recipe->getSlug()) ?>">Voir plus</a></td>                  
                        </tr>
         <?php   }} ?>
           
                </tbody>
            </table>
        </div>
 </section>