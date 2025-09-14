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
    <h1 class="text-center">Utilisateurs</h1>
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
</main>