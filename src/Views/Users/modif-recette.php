<?php
namespace Carbe\App\Views\Users;


?>

<main class='container p-3 bg-light'> 
    <?php
    if (isset($_SESSION['flash'])) {  ?>
       <div class='alert alert-primary'><?=$_SESSION['flash']?></div>
    <?php    unset($_SESSION['flash']); 
    }
    ?>
    <h2 class='text-center fs-2 mb-3'><?= $recipe->getTitle() ?>  </h2>
    <span class="badge text-bg-secondary"> <?= $recipe->getCategory()->getName()?></span>
    <span class="badge text-bg-secondary">Temps de préparation: <?= $recipe->getDuration()?> minutes</span>
    <form action="/update/recette" method="POST" class="mt-4" onsubmit="return confirm('Etes vous sur de vouloir modifier votre recette?');">
            <input type="hidden" name="id" value="<?= $recipe->getId() ?>">
            <h3 class="text-center">Modifier les ingrédients</h3>
            <?php foreach ($recipe->getIngredients() as $recipeIngredient): ?>
                <?php 
                    $ingredient = $recipeIngredient->getIngredient(); 
                    $id = $ingredient->getId();
                    $name = $ingredient->getName();
                    $quantity = $recipeIngredient->getQuantity();
                    $unit = $recipeIngredient->getUnit();
                    
                ?>
            <div class="row mb-2">
                <input type="hidden" name="ingredients[]" value="<?= htmlspecialchars($id) ?>" class="form-control">
                <div class="col-md-4">
                    <input type="text" value="<?= htmlspecialchars($name) ?>" class="form-control" readonly>
                </div>
                <div class="col-md-4">
                    <input type="number" step="any" name="quantites[]" value="<?= htmlspecialchars($quantity) ?>" class="form-control">
                </div>
                <div class="col-md-4">
                    <input type="text" name="unit[]" value="<?= htmlspecialchars($unit) ?>" class="form-control">
                </div>
            
            </div>
            <?php endforeach; ?>
            <?php
            $steps = json_decode($recipe->getDescription(), true);
            ?>
            <h3 class="text-center mt-4">Modifier la préparation</h3>
            <div class="mb-2">
                <label for="duration" class="form-label">Temps de Preparation</label>
                <input type="text" name="duration" id="duration" value="<?= $recipe->getDuration()?>" class="form-control">
            </div>
            <?php foreach ($steps as $i => $step): ?>
            <div class="mb-2">
                <label for="step_<?= $i ?>" class="form-label">Étape <?= $i + 1 ?></label>
                <textarea class="form-control" id="step_<?= $i ?>" name="description[]"><?= htmlspecialchars($step) ?></textarea>
            <?php endforeach; ?>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-secondary">Enregistrer les modifications</button>
            </div>
    </form>

</main>