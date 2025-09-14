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
    <section class="mb-4 d-flex justify-content-center">
        <form method="get" action="/admin/search" class="w-50">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Rechercher un utilisateur" name="q" required>
                <button class="btn btn-primary" type="submit">🔍</button>
            </div>
        </form>
   </section>
   <section class="row d-flex justify-content-center">
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
                    <?php if(!empty($users)) {
                     foreach($users as $user) {  ?>
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
</main>