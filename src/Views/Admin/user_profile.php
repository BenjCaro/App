<?php 

namespace Carbe\App\Views\Admin;
use Carbe\App\Services\Csrf;


?>

<main class='container p-3 bg-light border-end border-start border-secondary'>
    <section class="row d-flex flex-column align-items-center justify-content-center gap-2">
        <h3 class="text-center">Informations <?= htmlspecialchars($user->getName() . ' ' . $user->getFirstname()) ?></h3>
        <form class="card col-6" id="formInformation" action="/admin/profil/utilisateur-<?= htmlspecialchars($user->getId()) ?>/update-informations" method="POST">
            <?php $token = Csrf::get("admin_update_profil");  ?>
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
        <form class="card col-6" id="formDescription" action="/admin/profil/utilisateur-<?= htmlspecialchars($user->getId()) ?>/update-description" method="POST">
            <?php $token = Csrf::get("admin_update_description");  ?> 
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
        <form class="card col-6" action="/admin/profil/utilisateur-<?= htmlspecialchars($user->getId()) ?>/update-role" id="formRole" method="POST">
            <div class="card-body">
                <?php $token = Csrf::get("admin_update_role");  ?>
                <input type="hidden" name="_token" value="<?= $token ?>">
                <label for="role" class="form-label">Modifier le role de l'utilisateur</label>
                <select name="role" id="role" class="form-select bg-gris" disabled>
                    <option value="<?= $user->getRole() ?> ?>"><?= $user->getRole() ?></option>
                    <option value="admin">admin</option>
                </select>
            </div>
            <div class="d-flex justify-content-center mb-2 gap-2">
                    <button type="button" id="editRole" class="btn btn-sm btn-primary">Modifier le rôle</button>
                    <button type="submit" id="hiddenSubmitRole" class="d-none"></button>
                </div>
        </form>
        <form id="formDelete" action="/admin/profil/suppr-utilisateur-<?= htmlspecialchars($user->getId()) ?>" method="POST" class="card col-12 col-md-8 col-lg-6 p-4 shadow">
            <button type="submit" class="btn btn-sm btn-secondary">Supprimer <?= htmlspecialchars($user->getName() . ' ' . $user->getFirstname()) ?> </button>
        </form>
    </section>
    <section class="row d-flex justify-content-center">
        <h3 class="text-center mt-4 mb-4">Recettes ajoutées par <?= htmlspecialchars($user->getName() . ' ' . $user->getFirstname()) ?></h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Catégorie</th>
                    <th>Titre</th>
                    <th>Lien</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($recipes as $recipe) { ?>
                    <tr>
                        <td><?= htmlspecialchars($recipe->getCategory()->getName()) ?></td>
                        <td><?= htmlspecialchars($recipe->getTitle()) ?></td>
                        <td><a href="/recette/<?= urlencode($recipe->getSlug()) ?>" class="btn btn-sm btn-outline-primary">Consulter</a></td>
                        <td>
                           <button type="submit" class="btn btn-sm btn-primary"><a href="/update/recette/<?= urlencode($recipe->getSlug()) ?>" class="nav-link">Modifier</a></button>
                        </td>
                        <td>
                            <form method="POST" action="/mon-compte/suppr-recette" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?');">
                                <input type="hidden" name="recipe" value="<?= $recipe->getId()?>">
                                <button type="submit" class="btn btn-sm btn-secondary">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php  } ?>
               
            </tbody>
            </table>
        </div>
    </section>
     <section class="row d-flex justify-content-center">
        <h3 class="text-center mt-4 mb-4">Favoris de <?= htmlspecialchars($user->getName() . ' ' . $user->getFirstname()) ?></h3>
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
                    <?php foreach ($favoris as $favori) { ?>
                    <tr>
                        <td><?= htmlspecialchars($favori->getCategory()->getName())?></td>
                        <td><?= htmlspecialchars($favori->getTitle()) ?></td>
                        <td><a href="/recette/<?= urlencode($favori->getSlug()) ?>" class="btn btn-sm btn-outline-primary">Consulter</a></td>
                        <td>
                            <form method="POST" action="/mon-compte/suppr-favoris" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer des favoris ?');">
                                <input type="hidden" name="favoris" value="<?= $favori->getId()?>">
                                <button type="submit" class="btn btn-sm btn-secondary">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
    <section>
        <h3 class="text-center mt-4 mb-4">Mes Commentaires</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Recette</th>
                    <th>Consulter la recette</th>
                    <th>Etat</th>
                    <th>Voir le commentaire</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post) { ?>
                    <tr id="<?= $post->getId()?>">
                        <td><?= htmlspecialchars($post->getCreatedAt()) ?></td>
                        <td><?= htmlspecialchars($post->getRecipe()->getTitle()) ?></td>
                        <td><a href="/recette/<?= urlencode($post->getRecipe()->getSlug())?>#post-<?=$post->getId() ?>" class="btn btn-sm btn-outline-primary">Voir la recette</a></td>
                        <?php if(($post->getIsApproved()) === true) { ?>
                            <td>Publié</td>
                       <?php } else {  ?>
                            <td>En attente de validation</td>
                        <?php  } ?>
                        <td>
                           <button type="submit" class="btn btn-sm btn-primary"><a href="/mes-commentaires/commentaire-<?=$post->getId()?>" class="nav-link">Modifier le commentaire</a></button>
                        </td>
                    </tr>
                <?php  } ?>
               
            </tbody>
            </table>
        </div>
    </section>
</main>
<script type="module" src="/assets/scripts/Admin/updateProfileUser.js"></script>