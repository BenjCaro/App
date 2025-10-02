<?php

namespace Carbe\App\Views\Admin;
use Carbe\App\Services\Auth;

/** @var string $title */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <title><?= $title ?></title>
</head>
<body>
    <header class="border-bottom  border-cacao border-2">
        <nav class="navbar navbar-expand-lg bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <img src="/assets/images/Icone_Petit_Creux.svg" alt="Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
                    <span class="navbar-toggler-icon"></span>
                </button>
               <div class="collapse navbar-collapse" id="menuPrincipal">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item fs-5"><a class="nav-link" href="/admin">Tableau de Bord</a></li>
                        <li class="nav-item fs-5"><a class="nav-link" href="/admin/tous-les-utilisateurs">Utilisateurs</a></li>
                        <li class="nav-item fs-5"><a class="nav-link" href="/admin/toutes-les-recettes">Recettes</a></li>
                        <li class="nav-item fs-5"><a class="nav-link" href="">Commentaires</a></li>
                        <li class="nav-item fs-5"><a class="nav-link" href="/admin/categories">Catégories</a></li> 
                        <li class="nav-item fs-5"><a class="nav-link" href="/admin/ingredients">Ingrédients</a></li>
                        <li class="nav-item fs-5"><a class="nav-link" href="/logout">Déconnexion</a></li>   
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</body>
