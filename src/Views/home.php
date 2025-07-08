<?php
namespace Carbe\App\Views;

/** @var Carbe\App\Models\RecipeModel[] $favoris */
/** @var Carbe\App\Models\RecipeModel $lastRecipe */
/** @var Carbe\App\Models\RecipeModel $popularRecipe */
/** @var Carbe\App\Models\CategoryModel $categories */

?>
<main class='container p-3 bg-light border-end border-start border-secondary'>
    <!-- <div class="container-fluid mt-2">
        <form class="d-flex" role="search">
        <input class="form-control me-2 bg-gris" type="search" placeholder="Recherche" aria-label="Search"/>
        <button class="btn btn-outline-success" type="submit"><img src="/assets/images/search.svg" alt=""></button>
        </form>
   </div> -->
  
   <!-- Mise en place des cards -->
    <h2 class="text-center">Bienvenue  <?= $user->getFirstname();?></h2>
    <div class="grid mt-1 mb-3">
        <section class="favoris">
            <div class="card bg-gris h-100 border border-primary" >
                <div class="card-body ">
                    <h2 class='card-title text-center'>Mes favoris</h2>
                        <?php
                    foreach ($favoris as $recipe) {  ?>
                        <h3 class="card-subtitle text-body-secondary fs-4 mb-2"> 
                                <?= $recipe->getTitle()?>
                            <span class="fs-6">durée: <?= $recipe->getDuration() . 'mns' ?></span>
                        </h3>
                        <span class="badge text-bg-secondary"><?= $recipe->getCategory()->getName(); ?></span>
                        <a class="text-secondary nav-link" href="/recette/<?= $recipe->getSlug(); ?>">Voir la recette</a>
                        <?php } ?>
                </div>
            </div>
        </section>
        <section class="last_recipe">
            <div class="card bg-gris h-100 border border-primary">
                <div class="card-body">
                    <h2 class='card-title'>Dernière Recette</h2>
                        <h3 class="card-subtitle mb-2 text-body-secondary fs-4"> 
                                <?= $lastRecipe->getTitle()?>
                            <span class="fs-6">durée: <?= $lastRecipe->getDuration() . 'mns' ?></span>
                        </h3>
                        <span class="badge text-bg-secondary"><?=  ucwords($lastRecipe->getCategory()->getName());?></span>
                        <a class="text-secondary nav-link" href="/recette/<?= $lastRecipe->getSlug(); ?>">Voir la recette</a>
              </div>
            </div>
        </section>
        <section class="popular_recipe">
            <div class="card bg-gris h-100 border border-primary" >
                <div class="card-body">
                    <h2 class='card-title'>Recettes Populaires</h2>
                        <h3 class="card-subtitle mb-2 text-body-secondary fs-4"> 
                                <?= $popularRecipe->getTitle()?>
                            <span class="fs-6">durée: <?= $popularRecipe->getDuration() . 'mns' ?></span>
                        </h3>
                        <span class="badge text-bg-secondary"><?=  ucwords($popularRecipe->getCategory()->getName());?></span>
                        <a class="text-secondary nav-link" href="/recette/<?= $popularRecipe->getSlug(); ?>">Voir la recette</a>        
                </div>
            </div>
        </section>
        <section class="categories text-center">
            <div class="card bg-gris h-100 border border-primary" >
                <div class="card-body">
                    <h2 class='card-title'>Catégories</h2>
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
    </div>
   
     
</main>