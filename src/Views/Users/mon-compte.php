<?php
namespace Carbe\App\Views\Pages;

if (!isset($_SESSION['auth_user'])) {
    $_SESSION['flash'] = "Connectez-vous pour accèder à cette page!";
    header('Location: /login');
    exit();
}

?>

<main class='container p-3 bg-light border-end border-start border-secondary'>
    <?php
     if (isset($_SESSION['flash'])) {  ?>
       <div class='alert alert-secondary'><?=$_SESSION['flash']?></div>
    <?php    unset($_SESSION['flash']); 
    }

    ?>
    <h2 class="text-center">Bienvenue sur votre Espace Membre <?= $user->getFirstname()?> </h2>
    <section class="row d-flex justify-content-center">
        <div class="card col-6">
            <div class="card-body">
                <h3 class="card-title">Mes informations</h3>
                <h4 class="card-subtitle fs-5 mb-2 text-body-secondary"><?= $user->getFirstname(); ?> <?= $user->getName(); ?></h4>
                <p class="card-text"><?= $user->getDescription()?></p>
                <span class="card-text"> <?= $user->getEmail(); ?>  </span><br>
                <span class="card-text">Membre depuis: <?= $user->getCreatedAt() ?></span>
            </div>
        </div>
    </section>
    <section class="row d-flex justify-content-center">
        <h3 class="text-center mt-4 mb-4">Mes favoris</h3>
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
                        <form method="POST" action="/mon-compte/suppr-favoris">
                            <input type="hidden" name="recipe" value="<?= $recipe->getId()?>">
                            <button type="submit" class="btn btn-sm btn-secondary btn-outline-primary">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            </table>
        </div>
</section>
    <section class="row d-flex justify-content-center">
        <h3 class="text-center mt-4 mb-4">Mes recettes ajoutées</h3>
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
                <?php foreach($userRecipes as $userRecipe) { ?>
                    <td><?= htmlspecialchars($userRecipe->getId()) ?></td>
                    <td><?= htmlspecialchars($userRecipe->getTitle()) ?></td>
                    <td><a href="/recette/<?= urlencode($useRecipe->getSlug()) ?>" class="btn btn-sm btn-outline-primary">Consulter</a></td>

                <?php  } ?>
                <!-- Afficher les recettes ajoutées par l'utilisateur modifier/supprimer -->
            </tbody>
            </table>
        </div>
    </section>
    <section class="row d-flex justify-content-center">
        Mes commentaires
<!-- Afficher les commentaires ajoutés par l'utilisateur modifier/supprimer -->
<!-- utiliser meme structure tableau que favoris -->
    </section>
</main>

