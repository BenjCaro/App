<?php
namespace Carbe\App\Views\Admin;

?>
<main class='container p-3 bg-light'>
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
                     foreach($results as $result) {  ?>
                        <tr>
                            <td><?= htmlspecialchars($result->getCreatedAt()) ?></td>
                            <td><?= htmlspecialchars($result->getName()) ?></td>
                            <td><?= htmlspecialchars($result->getFirstName()) ?></td>
                            <td><?= htmlspecialchars($result->getEmail()) ?></td>
                            <td><a href="/admin/profil/utilisateur-<?= $result->getId() ?>">Voir plus</a></td>  
                        </tr>
                        
                     <?php   }} ?>
                    
                </tbody>
            </table>
        </div>
    </section>
</main>