<?php
namespace Carbe\App\Views\Pages\Views;



/** @var Carbe\App\Models\RecipeModel[] $recipes */



?>

<main class='container p-3 bg-light'> 
     <?php foreach($recipes as $recipe) { ?>
         <h3><?= $recipe->getTitle(); ?></h3>
         <span class="fs-6">durée: <?= $recipe->getDuration() . 'mns' ?></span>
         <a class="text-secondary nav-link" href="/recette/<?= $recipe->getSlug(); ?>">Voir la recette</a>
    <?php   } ?>
</main>

