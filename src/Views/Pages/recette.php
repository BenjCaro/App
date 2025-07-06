<?php

namespace Carbe\App\Views\Pages;

?>

<main class='container p-3 bg-light'> 
    <h2>Ingrédients</h2>
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
</main>