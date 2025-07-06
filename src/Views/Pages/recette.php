<?php

namespace Carbe\App\Views\Pages;

?>

<main class='container p-3 bg-light'> 
    <h2 class='text-center fs-2'><?= $recipe->getTitle() ?></h2>
    <h3 class='fs-3'>Ingrédients</h3>
<ul>
<?php foreach ($recipe->getIngredients() as $recipeIngredient): ?>
    <?php 
        $ingredient = $recipeIngredient->getIngredient(); 
        $name = $ingredient->getName();
        $quantity = $recipeIngredient->getQuantity();
        $unit = $recipeIngredient->getUnit();
    ?>
    <li><?= htmlspecialchars($quantity) ?> <?= htmlspecialchars($unit) ?> de <?= htmlspecialchars($name) ?></li>
<?php endforeach; ?>
</ul>
<?php
$steps = json_decode($recipe->getDescription(), true); // true pour avoir un tableau associatif
?>

<h2>Préparation</h2>
<ol>
<?php foreach ($steps as $step): ?>
    <li><?= htmlspecialchars($step) ?></li>
<?php endforeach; ?>
</ol>
</main>