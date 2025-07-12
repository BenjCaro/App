<?php
namespace Carbe\App\Views\Pages;



if (!isset($_SESSION['auth_user'])) {
    $_SESSION['flash'] = "Connectez-vous pour accèder à cette page!";
    header('Location: /login');
    exit();
}
?> 

<main>

    <h1>Mon Compte <?= $user->getName(); ?></h1>

</main>

