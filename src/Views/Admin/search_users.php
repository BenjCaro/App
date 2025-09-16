<?php

namespace Carbe\App\Views\Admin; ?>

<section class="row d-flex justify-content-center">
        <h1 class="text-center">Résultat(s)</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Membre depuis</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                  <?php if(!empty($results)) {
                     foreach($results as $user) {  ?>
                           <tr>
                              <td><?= htmlspecialchars($user->getCreatedAt()) ?></td>
                              <td><?= htmlspecialchars($user->getName()) ?></td>
                              <td><?= htmlspecialchars($user->getFirstName()) ?></td>
                              <td><?= htmlspecialchars($user->getEmail()) ?></td>
                              <td><a href="/admin/profil/utilisateur-<?= $user->getId() ?>">Voir plus</a></td>                  
                           </tr>
         <?php   }} ?>
                </tbody>
            </table>
        </div>
    </section>