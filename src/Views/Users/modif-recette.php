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

            <?php foreach ($recipe->getIngredients() as $i => $recipeIngredient): ?>
                <?php 
                    $ingredient = $recipeIngredient->getIngredient(); 
                    $id = $ingredient->getId();
                    $quantity = $recipeIngredient->getQuantity();
                    $unit = $recipeIngredient->getUnit();
                ?>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <select name="ingredients[]" class="form-select">
                            <?php foreach ($ingredients as $ing): ?>
                                <option value="<?= $ing->getId() ?>" <?= $ing->getId() === $id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($ing->getName()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="number" step="any" name="quantites[]" value="<?= htmlspecialchars($quantity) ?>" placeholder="Quantités" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="unit[]" value="<?= htmlspecialchars($unit) ?>" placeholder="unités" class="form-control">
                    </div>
                </div>
            <?php endforeach; ?>

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
            <?php foreach ($steps as $i => $step): ?>
            <div class="mb-2">
                <label for="step_<?= $i ?>" class="form-label">Étape <?= $i + 1 ?></label>
                <textarea class="form-control" id="step_<?= $i ?>" name="description[]"><?= htmlspecialchars($step) ?></textarea>
            </div>
            <?php endforeach; ?>
            <div>
                <button type="button" onclick="" class="btn btn-sm btn-outline-secondary">+ Ajouter une étape</button>
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

function addIngredient() {
    const container = document.getElementById('ingredients-container');

    const div = document.createElement('div');
    div.classList.add('d-flex', 'mb-2', 'gap-2');

    // Select d'ingrédients
    const select = document.createElement('select');
    select.name = 'ingredients[]';
    select.classList.add('form-select', 'w-50');
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    defaultOption.textContent = 'Choisir un ingrédient';
    select.appendChild(defaultOption);

    ingredientsData.forEach(ing => {
        const option = document.createElement('option');
        option.value = ing.id;
        option.textContent = ing.name;
        select.appendChild(option);
    });

    // Input quantité
    const input = document.createElement('input');
    input.name = 'quantites[]';
    input.type = 'text';
    input.placeholder = 'Quantité';
    input.classList.add('form-control', 'w-25');

    // Input Unité

    const unit = document.createElement('input');
    unit.name = 'unit[]';
    unit.type = 'text';
    unit.placeholder = 'Unité';
    unit.classList.add('form-control', 'w-25');

    // Bouton suppression
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.textContent = 'x';
    btn.classList.add('btn', 'btn-secondary');
    btn.onclick = () => div.remove();

    div.appendChild(select);
    div.appendChild(input);
    div.appendChild(unit);
    div.appendChild(btn);

    container.appendChild(div);
}

</script>