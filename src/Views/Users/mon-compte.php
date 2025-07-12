<?php
namespace Carbe\App\Views\Pages;



if (!isset($_SESSION['auth_user'])) {
    $_SESSION['flash'] = "Connectez-vous pour accèder à cette page!";
    header('Location: /login');
    exit();
}
?> 

<main class='container p-3 bg-light border-end border-start border-secondary'>

    <h2>Mon Compte <?= $user->getName(); ?></h2>

</main>

