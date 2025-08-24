<?php
namespace Carbe\App\Views;

use Carbe\App\Models\CategoryModel;
use Carbe\App\Models\RecipeModel;


/** @var \Carbe\App\Models\RecipeModel[] $favoris */
/** @var \Carbe\App\Models\RecipeModel|null $lastRecipe */
/** @var \Carbe\App\Models\RecipeModel|null $popularRecipe */
/** @var \Carbe\App\Models\CategoryModel[] $categories */

?>
<main class='container p-3 bg-light'>
    <?php
    if (isset($_SESSION['flash'])) {  ?>
       <div class='alert alert-primary'><?=$_SESSION['flash']?></div>
    <?php    unset($_SESSION['flash']); 
    }
    ?>
    <div class="search-bar">
        <form class="d-flex gap-2" method="get" action="/search">
            <input class="form-control" type="text" name="q" placeholder="Rechercher..." required>
            <button class="btn btn-secondary" type="submit">🔍</button>
        </form>
    </div>
    <div class="grid mt-1 mb-3">
        <section class="favoris">
            <div class="card bg-gris h-100 border border-primary" >
                <div class="card-body ">
                <?php if (isset($_SESSION['auth_user'])):  ?>
                    <h2 class='card-title text-center'>Vos favoris</h2>
                    <?php    
                        if(!$favoris): ?>
                            <div class="text-center">Pas encore de Favoris</div>
                        <?php else: 
                            foreach ($favoris as $recipe) {  ?>
                        <h3 class="card-subtitle text-body-secondary fs-4 mt-2 mb-2"> 
                                <?= $recipe->getTitle()?>
                        </h3>
                        <span class="badge text-bg-secondary"><?= htmlspecialchars(strval($recipe->getDuration())) . ' minutes' ?></span>
                        <span class="badge text-bg-secondary"><?= $recipe->getCategory()->getName(); ?></span> <br>
                        <button type="button" class="btn btn-secondary mt-2"><a class="text-black nav-link" href="/recette/<?= $recipe->getSlug()?>">Voir la recette</a></button>
                        <?php } ?>
                    <?php endif; ?>
                    <?php else: ?>
                    <h3 class="text-center">
                        Bienvenue sur Petit Creux!
                    </h3>
                    <p>Pour profiter pleinement de la communauté Petit Creux, rejoignez-nous en cliquant <a href="/login">ici</a>.</p>
                <?php endif; ?>
                </div>
            </div>
        </section>
        <section class="last_recipe">
            <div class="card bg-gris h-100 border border-primary">
                <div class="card-body">
                    <h2 class='card-title'>Dernière Recette</h2>
                    <!-- warning phpStan car la comparaison retourne tjs false c est à dire ne pas donner null lastRecipe est tjs un objet-->
                    <?php if($lastRecipe === null)  { ?>
                            <div class="text-center">Pas encore de recette</div>
                     <?php  } else {?>
                        <h3 class="card-subtitle mb-2 text-body-secondary fs-4"> 
                                <?= $lastRecipe->getTitle()?>
                        </h3>
                        <span class="badge text-bg-secondary"><?= $lastRecipe->getDuration() . ' minutes' ?></span>
                        <span class="badge text-bg-secondary"><?=  ucwords($lastRecipe->getCategory()->getName());?></span> <br>
                       <button type="button" class="btn btn-secondary mt-2"><a class="text-black nav-link" href="/recette/<?= $lastRecipe->getSlug()?>">Voir la recette</a></button>
                    <?php } ?>
                </div>
            </div>
        </section>
        <section class="popular_recipe">
            <div class="card bg-gris h-100 border border-primary" >
                <div class="card-body">
                    <h2 class='card-title'>Recettes Populaires</h2>
                    <!-- warning phpStan car la comparaison retourne tjs false c est à dire ne pas donner null popularRecipe est tjs un objet-->
                         <?php if($popularRecipe === null) { ?>
                            <div class="text-center">Pas encore de recette</div>
                        <?php  } else {?>
                        <h3 class="card-subtitle mb-2 text-body-secondary fs-4"> 
                                <?= $popularRecipe->getTitle()?>
                        </h3>
                        <span class="badge text-bg-secondary"><?= htmlspecialchars(strval($popularRecipe->getDuration())) . ' minutes' ?></span>
                        <span class="badge text-bg-secondary"><?=  ucwords($popularRecipe->getCategory()->getName());?></span> <br>
                        <button type="button" class="btn btn-secondary mt-2"><a class="text-black nav-link" href="/recette/<?= $popularRecipe->getSlug()?>">Voir la recette</a></button>      
                        <?php } ?>
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
        <a href="/ajout-recette">Ajouter une recette</a>
    </div>
   
     
</main>