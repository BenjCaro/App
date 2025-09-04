<?php

namespace Carbe\App\Views\Admin;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css">
    <title><?= $title ?></title>
</head>
<body>
    <header class="border-bottom  border-cacao border-2">
        <nav class="navbar navbar-expand-lg bg-primary">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div>
                    <a href="/admin" class="nav-link fs-5">Tableau de Bord</a>
                </div>
                <div class="collapse navbar-collapse" id="menuPrincipal">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item fs-5"><a class="nav-link" href="">Utilisateurs</a></li>
                        <li class="nav-item fs-5"><a class="nav-link" href="">Recettes</a></li>
                        <li class="nav-item fs-5"><a class="nav-link" href="">Commentaires</a></li>
                        <li class="nav-item fs-5"><a class="nav-link" href="">Catégories</a></li> 
                        <li class="nav-item fs-5"><a class="nav-link" href="">Ingrédients</a></li>
                        <li class="nav-item fs-5"><a class="nav-link" href="">Déconnexion</a></li>      
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</body>
