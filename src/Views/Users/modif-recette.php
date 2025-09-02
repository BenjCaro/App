<?php
namespace Carbe\App\Views\Users;
use Carbe\App\Services\Csrf;
use Carbe\App\Models\RecipeModel;
use Carbe\App\Models\IngredientModel;
use Carbe\App\Services\Flash;
/** @var mixed $i */
/** @var \Carbe\App\Models\RecipeModel $recipe */
/** @var \Carbe\App\Models\IngredientModel[] $ingredients */
?>

<main class='container p-3 bg-light'> 
   <?php
     $messages = Flash::get();
     foreach($messages as $message) { ?>
        <div class="alert alert-<?= $message['type'] ?>"><?= $message['message']?></div>
    <?php }
    ?>
    <h2 class='text-center fs-2 mb-3'><?= $recipe->getTitle() ?>  </h2>
    <span class="badge text-bg-secondary"> <?= $recipe->getCategory()->getName()?></span>
    <span class="badge text-bg-secondary">Temps de préparation: <?= $recipe->getDuration()?> minutes</span>
    <form action="/update/recette" method="POST" class="mt-4" onsubmit="return confirm('Etes vous sur de vouloir modifier votre recette?');">
            <input type="hidden" name="id" value="<?= $recipe->getId() ?>">
            <?php $token = Csrf::get("update_recipe");  ?>
            <input type="hidden" name="_token" value="<?= $token ?>">
            <h3 class="text-center">Modifier les ingrédients</h3>
            <?php if(!$recipe->getIngredients()) { ?>
                <div class="alert alert-secondary text-center" role="alert">
                     La recette n'a actuellement pas d'étape d'ingrédients.
                     Ajoutez des ingrédients.
                </div>
            <?php  } else { ?>
            <?php foreach ($recipe->getIngredients() as $i => $recipeIngredient): ?>
                <?php 
                    $ingredient = $recipeIngredient->getIngredient(); 
                    $id = $ingredient->getId();
                    $quantity = strval($recipeIngredient->getQuantity());
                    $unit = $recipeIngredient->getUnit();
                ?>
            <div class="d-flex mb-2 gap-2 align-items-center">
                    
                 <select name="ingredients[]" class="form-select">
                    <?php foreach ($ingredients as $ing): ?>
                    <option value="<?= $ing->getId() ?>" <?= $ing->getId() === $id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($ing->getName()) ?>
                    </option>
                         <?php endforeach; ?>
                </select>
                    <input type="number" step="any" name="quantites[]" value="<?= htmlspecialchars($quantity) ?>" placeholder="Quantités" class="form-control">
                    <input type="text" name="unit[]" value="<?= htmlspecialchars($unit) ?>" placeholder="unités" class="form-control">
                    <button class="btn btn-secondary" onclick="return confirm('Souhaitez-vous retirer cet ingrédient?')"><a class="nav-link" href="/suppr-ingredient/<?= $id ?>-<?= $recipe->getSlug() ?>">Supprimer</a></button>  
            </div>
            <?php endforeach; } ?>
            <h3 class="text-center">Ajouter des ingrédients</h3>
            <div id="ingredients-container"></div>
            <button type="button" onclick="addIngredient()" class="btn btn-sm btn-outline-secondary">+ Ajouter un ingrédient</button>
            <?php
            $steps = json_decode($recipe->getDescription(), true);
            ?>
            <h3 class="text-center mt-4">Modifier la préparation</h3>
            <div class="mb-2">
                <label for="duration" class="form-label">Temps de Preparation</label>
                <input type="text" name="duration" id="duration" value="<?= $recipe->getDuration()?>" class="form-control">
            </div>
            <?php if(!$steps) {?>
                <div class="alert alert-secondary text-center" role="alert">
                    La recette n'a actuellement pas d'étape de préparation. 
                    Ajoutez des étapes de préparation à la recette.
                </div>
            <?php  }  else { ?>
            <?php foreach ($steps as $i => $step): ?>
            <div class="mb-2">
                <label for="step_<?= $i ?>" class="form-label">Étape <?= $i + 1 ?></label>
                <textarea class="form-control" id="step_<?= $i ?>" name="description[]"><?= htmlspecialchars($step) ?></textarea>
            </div>
            <?php endforeach; } ?>
            <div id="description-container"></div>
            <div>
                <button type="button" onclick="addStep()" class="btn btn-sm btn-outline-secondary">+ Ajouter une nouvelle étape</button>
            </div>
            <!-- <div>
                    <textarea class="form-control" id="step_<?= $i ?>" name="description[]" placeholder="Ajouter une nouvelle étape"></textarea>
                </div> -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-secondary">Enregistrer les modifications</button>
            </div>
    </form>

</main>
<script>
    const ingredientsData = <?= json_encode(array_map(function($ingredient) {
    return [
        'id' => $ingredient->getId(),
        'name' => $ingredient->getName()
    ];
}, $ingredients)); ?>;
</script>
<script type="text/javascript" src="/assets/scripts/addIngredient.js"></script>
<script type="text/javascript" src="/assets/scripts/addStep.js"></script>