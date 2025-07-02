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
   <h1 class='text-center mt-2'>Inspirez votre prochain repas avec Petit Creux</h1>
    <div>
        <section>
        <h2>Mes favoris</h2>
            
        <?php

                foreach ($favoris as $recipe) {
                    echo $recipe->getTitle() . "<br>";
                }
                ?>

        </section>
        <section>
            <h2>Dernière recette</h2>
        </section>
        <section>
            <h2>Recettes Populaires</h2>
        </section>
        <section>
            <h2>Catégories</h2>
        </section>
    </div>
   
     
</main>