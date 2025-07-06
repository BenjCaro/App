<?php
namespace Carbe\App\Views\Pages\Views;

// afficher toutes les recettes de la catégorie
?>

<main class='container p-3 bg-light'> 
     <?php

     foreach($recipes as $recipe) {
        echo $recipe->getTitle();
    }
     ?>
</main>

