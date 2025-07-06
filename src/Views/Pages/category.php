<?php
namespace Carbe\App\Views\Pages\Views;

// afficher toutes les recettes de la catégorie

foreach($recipes as $recipe) {
    echo $recipe->getTitle();
    // afficher le slug de la recette 
    
}