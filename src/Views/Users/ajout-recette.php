<?php 
namespace Carbe\App\Views\Users;


?>


<main class='container p-3 bg-light'>
    <div class="d-flex flex-column w-50 m-auto">
        <form action="/ajout-recette" method="post" class="form-control pb-2">
            <input type="hidden" name="id_user" id="id_user" value="<?=$_SESSION['auth_user']['id'] ?>">
            <div class="mb-2">
                <label for="title" class="form-label">Titre de la recette</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="id_category" class="form-label">Catégorie</label>
                <select name="id_category" id="id_category" class="form-select" required>
                    <option value="">Choisir la catégorie</option>
                <?php foreach($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category->getId()); ?>"><?= htmlspecialchars($category->getName()); ?></option>
                <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-2">
                <label for="duration" class="form-label">Temps de préparation</label>
                <input type="text" id="duration" name="duration" placeholder="Préciser le temps de préparation" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Sélectionner les ingrédients</label>
                <div id="ingredients-container"></div>
                <button type="button" onclick="ajouterIngredient()" class="btn btn-sm btn-outline-secondary">+ Ajouter un ingrédient</button>
            </div>
            <div class="mb-2">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" placeholder="Décrivez les étapes de la recette" required></textarea>
            </div>
            <div class="text-center mt-2 mb-2">
                <button class="btn btn-secondary w-25" type="submit">Valider</button>
            </div>
        </form>
    </div>
</main>
<script>
    const ingredientsData = <?= json_encode(array_map(function($ingredient) {
    return [
        'id' => $ingredient->getId(),
        'name' => $ingredient->getName()
    ];
}, $ingredients)); ?>;

function ajouterIngredient() {
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
    btn.textContent = '❌';
    btn.classList.add('btn', 'btn-danger');
    btn.onclick = () => div.remove();

    div.appendChild(select);
    div.appendChild(input);
    div.appendChild(unit);
    div.appendChild(btn);

    container.appendChild(div);
}

</script>