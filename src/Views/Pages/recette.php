<?php

namespace Carbe\App\Views\Pages;
/** @var Carbe\App\Models\RecipeModel[] $recipes */
?>

<main class='container p-3 bg-light'> 
    
    <h2 class='text-center fs-2 mb-3'><?= $recipe->getTitle() ?>  </h2>
    <span class="badge text-bg-secondary">Temps de préparation: <?= $recipe->getDuration()?> minutes</span>
    <h3 class='mt-3 fs-3 text-center'>Ingrédients</h3>
    <div class="card bg-gris border border-primary w-50 p-3 mx-auto">
        <ul class="card-body list-unstyled">
        <?php foreach ($recipe->getIngredients() as $recipeIngredient): ?>
            <?php 
                $ingredient = $recipeIngredient->getIngredient(); 
                $name = $ingredient->getName();
                $quantity = $recipeIngredient->getQuantity();
                $unit = $recipeIngredient->getUnit();
            ?>
            <li class="card-text"><?= htmlspecialchars($quantity) ?> <?= htmlspecialchars($unit) ?> de <?= htmlspecialchars($name) ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php
$steps = json_decode($recipe->getDescription(), true); // true pour avoir un tableau associatif
?>
    <h3 class="mt-3 fs-3 text-center">Préparation</h3>
    <div class="card bg-gris border border-primary w-50 p-3 mx-auto">
        <ol class="card-body">
        <?php foreach ($steps as $step): ?>
            <li class="card-text"><?= htmlspecialchars($step) ?></li>
        <?php endforeach; ?>
        </ol>
    </div>
</main>