<?php

namespace Carbe\App\Views\Pages;
/** @var Carbe\App\Models\RecipeModel[] $recipes */

?>

<main class='container p-3 bg-light'> 
    <?php

    if (isset($_SESSION['flash'])) {  ?>
       <div class='alert alert-primary'><?=$_SESSION['flash']?></div>
    <?php    unset($_SESSION['flash']); 
    }
    ?>
    <?php if (isset($_SESSION['errors'])) {  ?>
       <div class='alert alert-secondary'><?=$_SESSION['errors']?></div>
    <?php    unset($_SESSION['errors']); 
    }
    ?>
    <h2 class='text-center fs-2 mb-3'><?= $recipe->getTitle() ?>  </h2>
    <span class="badge text-bg-secondary"> <?= $recipe->getCategory()->getName()?></span>
    <span class="badge text-bg-secondary">Temps de préparation: <?= $recipe->getDuration()?> minutes</span>
    <section>
        <h3 class='mt-3 fs-3 text-center'>Ingrédients</h3>
        <div class="card bg-gris border border-primary w-50 p-3 mx-auto">
            <ul class="card-body list-unstyled">
            <?php if(!$recipe->getIngredients()) { ?>
                <p>La recette n'a pas d'ingrédients.</p>
            <?php  }  else { ?>
            <?php foreach ($recipe->getIngredients() as $recipeIngredient): ?>
                <?php 
                    $ingredient = $recipeIngredient->getIngredient(); 
                    $name = $ingredient->getName();
                    $quantity = $recipeIngredient->getQuantity();
                    $unit = $recipeIngredient->getUnit();
                ?>
                <li class="card-text"><?= htmlspecialchars($quantity) ?> <?= htmlspecialchars($unit) ?> de <?= htmlspecialchars($name) ?></li>
            <?php endforeach; }?>
            </ul>
        </div>
    </section>

<?php
$steps = json_decode($recipe->getDescription(), true); // true pour avoir un tableau associatif
?>
    <section>
        <h3 class="mt-3 fs-3 text-center">Préparation</h3>
        <div class="card bg-gris border border-primary w-50 p-3 mx-auto">
            <ol class="card-body">
            <?php if(!$steps) {?>
                <p>La recette n'a actuellement pas d'étape de préparation.</p>
          <?php  }  else { ?>
            <?php foreach ($steps as $step): ?>
                <li class="card-text"><?= htmlspecialchars($step) ?></li>
            <?php endforeach; } ?>
            </ol>
        </div>
    </section>
    <section>
    <h3 class="mt-3 fs-3 text-center">Commentaires</h3>
    <?php if (empty($posts) && (isset($_SESSION['auth_user']))) : ?>
        <p>Soyez le premier à laisser un commentaire! </p>
    <?php else : ?>
        <?php foreach ($posts as $post) : ?>
            <div class="card w-50 my-2 p-2 mx-auto">
                <h4><?= htmlspecialchars($post->getTitle()) ?></h4>
                <p><?= htmlspecialchars($post->getContent()) ?></p>
                <span>Posté le : <?= htmlspecialchars($post->getCreatedAt()) ?> par <?= $post->getAuthor()->getName() . ' ' . $post->getAuthor()->getFirstname() ?></span>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

    <?php if (isset($_SESSION['auth_user'])): ?>
    <div class="d-flex justify-content-between mt-4">
        <div>
            <button id="btnPost" class="btn btn-primary">Laisser un commentaire</button>
        </div>
        <div>
           <form action="/recette/<?= htmlspecialchars($recipe->getSlug()) ?>/favoris" method="POST">
                <input type="hidden" name="user" value="<?= $_SESSION['auth_user']['id']; ?>" >
                <input type="hidden" name="recipe" value="<?= htmlspecialchars($recipe->getId()); ?>">
                <button class="btn btn-primary">Ajouter aux favoris</button>
            </form>
        </div>
    </div>
    <?php endif; ?>
    <section id="container" class="d-flex justify-content-center mt-2"></section>  
</main>

<script>
    const slug = <?= json_encode($recipe->getSlug())?>
 </script>
 <script type="text/javascript" src="/assets/scripts/addComment.js"></script>