<?php 
namespace Carbe\App\Views\Users;

// var_dump($_SESSION);
?>


<main class='container p-3 bg-light'>
    <div class="d-flex flex-column w-50 m-auto">
        <form action="" class="form-control pb-2">
            <input type="hidden" value="">
            <div class="">
                <label for="" class="form-label">Titre de la recette</label>
                <input type="text" class="form-control">
            </div>
            <div>
                <label for="" class="form-label">Catégorie</label>
                <select name="" id="" class="form-control">
                    <option value="">Choisir la catégorie</option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                </select>
            </div>
            <div>
                <div id="ingredients">
                    <label for="ingredient" class="form-label">Ingrédients</label>  
                </div>
            </div>
            <div>
                <label for="" class="form-label">Durée</label>
                <input type="text" class="form-control">
            </div>
            <div class="mb-2">
                <label for="" class="form-label">Description</label>
                <textarea class="form-control" name="" id="" placeholder="Décrivez les étapes de la recette"></textarea>
            </div>
            <div class="text-center mb-2">
                <button class="btn btn-secondary w-25" type="submit">Valider</button>
            </div>
        </form>
    </div>
</main>
<script>
    const ingredients = document.getElementById('ingredients');
    const select = document.createElement('select');

    select.name = 'ingredient';
    select.id = 'ingredient'
    select.classList.add('form-control');

    const option = document.createElement('option');
    const valueOption = 'choisir un ou plusieurs ingrédients';
    
    
    option.textContent = valueOption
    select.appendChild(option);
    ingredients.appendChild(select);
</script>