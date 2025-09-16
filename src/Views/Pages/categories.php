<?php
namespace Carbe\App\Views\Pages\Views;

use Carbe\App\Models\CategoryModel;
use Carbe\App\Models\RecipeModel;


/** @var \Carbe\App\Models\CategoryModel[] $categories */
/** @var \Carbe\App\Models\RecipeModel[] $recipesByCategory */
?>

<main class='container p-3 bg-light border-end border-start border-secondary'>
    <div>
       <section class="categories text-center">
            <div class="card bg-white h-100 border border-primary" >
                <div class="card-body">
                    <h2 class='card-title text-center'>Catégories</h2>
                    <div class="d-flex justify-content-evenly align-items-start">
                        <?php foreach($categories as $category)  { ?>
                        <div class="d-flex flex-column justify-content-center mt-2">
                            <a class="text-secondary text-cacao nav-link" href="/categories/<?= $category->getSlug(); ?>"><?= ucwords($category->getName());?></a>
                            <img class="icone" alt="icone <?=$category->getName(); ?>" src="/assets/images/<?= $category->getImage();?>"/>
                        </div>
                    <?php    } ?>   
                    </div>    
                </div>
            </div>
        </section>
<?php foreach ($recipesByCategory as $entry): 
                    $category = $entry['category'];
                    $recipes = $entry['recipes'];
             ?>
            <section class="mt-2 mb-2">
                <div class="card bg-light h-100 border border-primary p-3">
                    <h2 class="text-center">
                        <?= htmlspecialchars($category->getName()) ?>
                    </h2>
                    <div class="row g-3">
                        <?php foreach ($recipes as $recipe): ?>
                            <div class="col-md-4">
                                <div class="card h-100 bg-white border border-secondary p-2 d-flex flex-column justify-content-end">
                                    <h3><?= htmlspecialchars($recipe->getTitle()) ?></h3>
                                    <span class="badge text-bg-secondary"><?= htmlspecialchars(strval($recipe->getDuration())) . ' minutes' ?></span>
                                  <button type="button" class="btn btn-primary mt-2"><a class="text-black nav-link" href="/recette/<?= $recipe->getSlug()?>">Voir la recette</a></button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
<?php endforeach; ?>
        
    </div>
</main>
