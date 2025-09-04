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
                    <span class="nav-item fs-5">Tableau de Bord</span>
                </div>
                <div class="collapse navbar-collapse" id="menuPrincipal">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item fs-5"><a class="nav-link" href="">Lien</a></li>
                        <li class="nav-item fs-5"><a class="nav-link" href="">Lien</a></li>
                        <li class="nav-item fs-5"><a class="nav-link" href="/mon-compte">Lien</a>
                        <li class="nav-item fs-5"><a class="nav-link" href="/logout">Connexion Deconnexion</a></li>      
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</body>
</body>