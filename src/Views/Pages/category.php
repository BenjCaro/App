<?php
namespace Carbe\App\Views\Pages\Views;

use Carbe\App\Models\RecipeModel;
use Carbe\App\Models\CategoryModel;

/** @var \Carbe\App\Models\RecipeModel[] $recipes */
/** @var \Carbe\App\Models\CategoryModel $category */

?>

<main class='container p-3 bg-light border-end border-start border-secondary'> 
     <h2 class="text-center"><?= ucfirst($category['name']) ?></h2>
     <div class="row g-3">
        <?php foreach ($recipes as $recipe): ?>
            <div class="col-md-4">
                <div class="card h-100 bg-primary border border-secondary p-2 d-flex flex-column justify-content-end">
                    <h3><?= htmlspecialchars($recipe->getTitle()) ?></h3>
                    <span class="badge text-bg-secondary"><?= htmlspecialchars(strval($recipe->getDuration())) . ' minutes' ?></span>
                    <button type="button" class="btn btn-secondary mt-2"><a class="text-black nav-link" href="/recette/<?= $recipe->getSlug()?>">Voir la recette</a></button>
                </div>
            </div>
         <?php endforeach; ?>
    </div>
</main>

