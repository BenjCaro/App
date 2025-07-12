<?php
namespace Carbe\App\Views\Pages;

if (!isset($_SESSION['auth_user'])) {
    $_SESSION['flash'] = "Connectez-vous pour accèder à cette page!";
    header('Location: /login');
    exit();
}
?> 

<main class='container p-3 bg-light border-end border-start border-secondary'>
    <h2 class="text-center">Mon Compte </h2>
    <section class="row d-flex justify-content-center">
        <div class="card col-6">
            <div class="card-body">
                <h5 class="card-title">Mes informations</h5>
                <h6 class="card-subtitle mb-2 text-body-secondary"><?= $user->getFirstname(); ?> <?= $user->getName(); ?></h6>
                <p class="card-text"><?= $user->getDescription()?></p>
                <span class="card-text"> <?= $user->getEmail(); ?>  </span><br>
                <span class="card-text">Membre depuis: <?= $user->getCreatedAt() ?></span>
            </div>
        </div>
    </section>
    <section class="row d-flex justify-content-center">
        Gérer mes favoris
<!-- Enlever une recette des favoris -->

    </section>
    <section class="row d-flex justify-content-center">
        Mes recettes ajoutées
<!-- Afficher les recettes ajoutées par l'utilisateur modifier/supprimer -->

    </section>
    <section class="row d-flex justify-content-center">
        Mes commentaires
<!-- Afficher les commentaires ajoutés par l'utilisateur modifier/supprimer -->
    </section>
</main>

