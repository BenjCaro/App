<?php 
namespace Carbe\App\Views\Users;
use Carbe\App\Models\CategoryModel;
use Carbe\App\Models\IngredientModel;
use Carbe\App\Services\Csrf;
use Carbe\App\Services\Flash;

/** @var \Carbe\App\Models\CategoryModel[] $categories */ 
/** @var \Carbe\App\Models\IngredientModel[] $ingredients */

?>
<main class='container p-3 bg-light'>
    <?php
     $messages = Flash::get();
     foreach($messages as $message) { ?>
        <div class="alert alert-<?= $message['type'] ?>"><?= $message['message']?></div>
    <?php }
    ?>
    <h2 class="text-center mb-2 mt-2">Confiez-nous vos repas préférés! </h2>
    <div class="d-flex flex-column w-50 m-auto">
    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-secondary">
            <ul class="list-unstyled">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>
   <form action="/ajout-recette" method="post" class="form-control pb-2 border-gris bg-gris shadow-sm p-3 mb-5 bg-body-gris rounded" style="--bs-bg-opacity: .5;">
            <input type="hidden" name="id_user" id="id_user" value="<?=$_SESSION['auth_user']['id'] ?>">
            <?php $token = Csrf::get("add_recipe");  ?>
            <input type="hidden" name="_token" value="<?= $token ?>">
            <div class="mb-2">
                <label for="title" class="form-label fw-bold">Titre de la recette</label>
                <input type="text" id="title" name="title" placeholder="Donner un titre à votre recette" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="id_category" class="form-label">Catégorie</label>
                <select name="id_category" id="id_category" class="form-select" required>
                    <option value="">Choisir la catégorie</option>
                <?php foreach($categories as $category): ?>
                    <option value="<?= $category->getId(); ?>"><?= htmlspecialchars($category->getName()); ?></option>
                <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-2">
                <label for="duration" class="form-label">Temps de préparation</label>
                <input type="text" id="duration" name="duration" placeholder="Préciser le temps de préparation" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="ingredients" class="form-label">Sélectionner les ingrédients</label>
                <div id="ingredients-container"></div>
                <button type="button" onclick="addIngredient()" class="btn btn-sm btn-outline-secondary">+ Ajouter un ingrédient</button>
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
</script>
<script type="text/javascript" src="/assets/scripts/addIngredient.js"></script>