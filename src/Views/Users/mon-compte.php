<?php
namespace Carbe\App\Views\Pages;



if (!isset($_SESSION['auth_user'])) {
    $_SESSION['flash'] = "Connectez-vous pour accèder à cette page!";
    header('Location: /login');
    exit();
}
?> 

<main class='container p-3 bg-light border-end border-start border-secondary'>
    <h2>Mon Compte </h2>
    <section>
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Mes informations</h5>
                <h6 class="card-subtitle mb-2 text-body-secondary"><?= $user->getFirstname(); ?> <?= $user->getName(); ?></h6>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                <p class="card-text"> <?= $user->getEmail(); ?>  </p>
            </div>
        </div>

    </section>
    


</main>

