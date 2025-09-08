<?php 

namespace Carbe\App\Views\Admin;
use Carbe\App\Services\Csrf;
?>

<main class='container p-3 bg-light border-end border-start border-secondary'>
    <section class="row d-flex flex-column align-items-center justify-content-center gap-2">
        <h3 class="text-center">Informations</h3>
        <form class="card col-6" id="formInformation" action="" method="POST">
         <!-- à definir -->   <?php $token = Csrf::get("");  ?>
            <input type="hidden" name="_token" value="<?= $token ?>">
            <div class="card-body">
                <div class="mb-2">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" id="name" name="name" class="form-control bg-gris" value="<?= $user->getName(); ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="firstname" class="form-label">Prénom</label>
                    <input type="text" class="form-control bg-gris" name="firstname" id="firstname" value="<?= $user->getFirstname(); ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control bg-gris" value="<?= $user->getEmail(); ?>" readonly>
                </div>
                 <div class="d-flex justify-content-center mb-2 gap-2">
                    <button type="button" id="editInformation" class="btn btn-sm btn-primary">Modifier les informations</button>
                    <button type="submit" id="hiddenSubmit" class="d-none"></button>
                </div>
            </div>    
        </form>
        <form class="card col-6" id="formDescription" action="" method="POST">
         <!-- à definir -->   <?php $token = Csrf::get("");  ?> 
            <input type="hidden" name="_token" value="<?= $token ?>">
            <div class="card-body">
                <div class="mb-2">
                    <label for="membership" class="form-label">Membre depuis</label>
                    <input type="text" class="form-control bg-gris" name="membership" id="membership" value="<?= $user->getCreatedAt() ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" class="form-control bg-gris" name="description" rows="4" readonly><?= $user->getDescription() ? $user->getDescription() : "Rédigez votre description."?></textarea>
                </div>
                <div class="d-flex justify-content-center mb-2 gap-2">
                    <button type="button" id="editDescription" class="btn btn-sm btn-primary">Modifier la description</button>
                    <button type="submit" id="hiddenDescriptionSubmit" class="d-none"></button>
                </div>
            </div>
        </form>
    </section>
     <section class="row d-flex justify-content-center">
        <h3 class="text-center mt-4 mb-4">Favoris</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Catégorie</th>
                        <th>Titre</th>
                        <th>Lien</th>
                        <th>Supprimer des favoris</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($favoris as $recipe) { ?>
                    <tr>
                        <td><?= htmlspecialchars($recipe->getCategory()->getName())?></td>
                        <td><?= htmlspecialchars($recipe->getTitle()) ?></td>
                        <td><a href="/recette/<?= urlencode($recipe->getSlug()) ?>" class="btn btn-sm btn-outline-primary">Consulter</a></td>
                        <td>
                            <form method="POST" action="/mon-compte/suppr-favoris" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer des favoris ?');">
                                <input type="hidden" name="favoris" value="<?= $recipe->getId()?>">
                                <button type="submit" class="btn btn-sm btn-secondary">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
