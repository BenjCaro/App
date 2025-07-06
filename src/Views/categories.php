<?php
namespace Carbe\App\Views;

?>

<main class='container p-3 bg-light'>
    <div>
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
        <section>
                        
                         <?php foreach($recipes as $recipe) { ?>

                                <p><?= $recipe->getTitle() ?></p>
                        <?php } ?>
        </section>
    </div>
</main>
