<?php
namespace Carbe\App\Views;

?>

<main class='container bg-light'>
    <div class="container-fluid mt-2">
        <form class="d-flex" role="search">
        <input class="form-control me-2 bg-gris" type="search" placeholder="Recherche" aria-label="Search"/>
        <button class="btn btn-outline-success" type="submit"><img src="/assets/images/search.svg" alt=""></button>
        </form>
   </div>
   <h1 class='text-center mt-2 mb-3'>Inspirez votre prochain repas avec Petit Creux</h1>
   
   
   
   <!-- Mise en place des cards -->
    <div class="grid mb-3">
        <section class="favoris">
            <div class="card bg-gris h-100" >
                <div class="card-body ">
                    <h2 class='card-title text-center'>Mes favoris</h2>
                        <?php
                    foreach ($favoris as $recipe) {  ?>
                        <h3 class="card-subtitle mb-2 text-body-secondary fs-4"> 
                                <?= $recipe->getTitle()?>
                            <span class="fs-6">durée: <?= $recipe->getDuration() . 'mns' ?></span>
                        </h3>
                        <a class="text-secondary" href="/<?= $recipe->getSlug(); ?>">Voir la recette</a>
                        <?php } ?>
                </div>
            </div>
        </section>
        <section class="last_recipe">
            <div class="card bg-gris h-100">
                <div class="card-body">
                    <h2 class='card-title'>Dernière Recette</h2>
                        <h3 class="card-subtitle mb-2 text-body-secondary fs-4"> 
                                <?= $lastRecipe->getTitle()?>
                            <span class="fs-6">durée: <?= $lastRecipe->getDuration() . 'mns' ?></span>
                        </h3>
                        <a class="text-secondary" href="/<?= $lastRecipe->getSlug(); ?>">Voir la recette</a>
              </div>
            </div>
        </section>
        <section class="popular_recipe">
            <div class="card bg-gris h-100" >
                <div class="card-body">
                    <h2 class='card-title'>Recettes Populaires</h2>
                        <h3 class="card-subtitle mb-2 text-body-secondary fs-4"> 
                                <?= $popularRecipe->getTitle()?>
                            <span class="fs-6">durée: <?= $popularRecipe->getDuration() . 'mns' ?></span>
                        </h3>
                        <a class="text-secondary" href="/<?= $popularRecipe->getSlug(); ?>">Voir la recette</a>        
                </div>
            </div>
        </section>
        <section class="categories text-center">
            <div class="card bg-gris h-100" >
                <div class="card-body">
                    <h2 class='card-title'>Catégories</h2>
                    <?php foreach($categories as $category)  { ?>
                        <a class="text-secondary" href="/<?= $category->getSlug(); ?>"><?= $category->getName();?></a> <br>
                        <img alt="icone <?=$category->getName(); ?>" src="/assets/images/<?= $category->getImage();?>"/>
                    <?php    } ?>       
                </div>
            </div>
        </section>
    </div>
   
     
</main>