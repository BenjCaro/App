<?php

namespace Carbe\App\Views\Pages;

use Carbe\App\Models\RecipeModel;
use Carbe\App\Models\PostModel;
use Carbe\App\Services\Flash;
use Carbe\App\Services\Csrf;
use Carbe\App\Services\Auth;

/** @var \Carbe\App\Models\PostModel[] $posts */
/** @var \Carbe\App\Models\RecipeModel $recipe */

?>

<main class='container p-3 bg-light'> 
    <?php
     $messages = Flash::get();
     foreach($messages as $message) { ?>
        <div class="alert alert-<?= $message['type'] ?>"><?= $message['message']?></div>
    <?php }
    ?>
    <?php if (isset($_SESSION['errors'])) {  ?>
       <div class='alert alert-secondary'><?=$_SESSION['errors']?></div>
    <?php    unset($_SESSION['errors']); 
    }
    ?>
    <h2 class='text-center fs-2 mb-3'><?= $recipe->getTitle() ?>  </h2>
    <span class="badge text-bg-secondary"> <?= $recipe->getCategory()->getName()?></span>
    <span class="badge text-bg-secondary">Temps de préparation: <?= $recipe->getDuration()?> minutes</span>
    <?php if (Auth::viewAdmin()): ?>
        <section class="row d-flex flex-column align-items-center justify-content-center gap-2">
        <h3 class="text-center">Informations</h3>
        <form class="card col-6" action="">
            <div class="card-body">
                <div class="mb-2">
                    <label for="">Créateur</label>
                    <input type="text" class="form-control bg-gris" value="<?= htmlspecialchars($recipe->getUser()->getName())?> <?= htmlspecialchars($recipe->getUser()->getFirstname())?>">
                </div>
                <div>
                    <label for="">Date de création</label>
                    <input type="text" class="form-control bg-gris" value="<?= htmlspecialchars($recipe->getCreatedAt())?>">
                </div>
            </div>
        </form>
        <form class="card col-6" id="formState" action="/admin/state/recette-<?= htmlspecialchars($recipe->getSlug()) ?>" method="POST">
            <?php $token = Csrf::get("admin_update_recipe");?>
            <input type="hidden" name="_token" value="<?= $token ?>">
            <input type="hidden" name="id" value="<?= $recipe->getId() ?>">
            <div class="card-body">
                <div class="mb-2">
                    <label for="state">Etat</label>
                    <?php $state = htmlspecialchars($recipe->getState()); ?>
                    <select class="form-select bg-gris" name="state" id="stateField" disabled>
                        <option value="<?= $state ?>"> <?= $state ?> </option>
                        <option value="<?= $state === "published" ? 'pending' : "published" ?>"><?= $state === "published" ? 'pending' : "published" ?></option>
                    </select>
                </div>
                 <div class="d-flex justify-content-center mb-2 gap-2">
                    <button type="button" id="editState" class="btn btn-sm btn-primary"><?= $state === "published" ? "Mettre en attente" : "Autoriser la publication" ?></button>
                    <button type="submit" id="hiddenSubmit" class="d-none"></button>
                </div>
            </div>    
        </form>
        <form  action="/admin/suppression-recette-<?= $recipe->getId()?>" method="POST" class="card col-12 col-md-8 col-lg-6 p-4 shadow">
            <button type="submit" class="btn btn-sm btn-secondary">Supprimer cette recette </button>
        </form>
    <?php endif; ?>
    <section>
        <h3 class='mt-3 fs-3 text-center'>Ingrédients</h3>
        <div class="card bg-white border border-primary w-50 p-3 mx-auto">
            <ul class="card-body list-unstyled">
            <?php if(!$recipe->getIngredients()) { ?>
                <p>La recette n'a pas d'ingrédients.</p>
            <?php  }  else { ?>
            <?php foreach ($recipe->getIngredients() as $recipeIngredient): ?>
                <?php 
                    $ingredient = $recipeIngredient->getIngredient(); 
                    $name = $ingredient->getName();
                    $quantity = strval($recipeIngredient->getQuantity());
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
        <div class="card bg-white border border-primary w-50 p-3 mx-auto">
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
                <div class="card w-50 my-2 p-2 mx-auto" id="post-<?=$post->getId(); ?>">
                    <h4><?= htmlspecialchars($post->getTitle()) ?></h4>
                    <p><?= htmlspecialchars($post->getContent()) ?></p>
                    <span>Posté le : <?= htmlspecialchars($post->getCreatedAt()) ?> par <?= $post->getAuthor()->getName() . ' ' . $post->getAuthor()->getFirstname() ?></span>
                    <?php if (isset($_SESSION['auth_user']) && (int)$post->getIdUser() === (int)$_SESSION['auth_user']['id']) : ?>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-sm btn-primary"><a href="/mes-commentaires/commentaire-<?=$post->getId();?>" class="nav-link">Modifier le commentaire</a></button>
                        </div>
                    <?php endif; ?>
               </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
    <section>
        <?php if (Auth::viewAuth()): ?>
        <div class="d-flex justify-content-between mt-4">
            <div>
                <button id="btnPost" data-slug="<?= htmlspecialchars($recipe->getSlug()) ?>" data-token="<?= htmlspecialchars(Csrf::get("add_comment")) ?>" class="btn btn-primary">Laisser un commentaire</button>
            </div>
            <div>
            <form action="/recette/<?= htmlspecialchars($recipe->getSlug()) ?>/favoris" method="POST">
                    <input type="hidden" name="user" value="<?= $_SESSION['auth_user']['id']; ?>" >
                    <input type="hidden" name="recipe" value="<?= $recipe->getId(); ?>">
                    <button class="btn btn-primary">Ajouter aux favoris</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
    </section>
    <section id="container" class="d-flex justify-content-center mt-2"></section>  
</main>
 <script type="text/javascript" src="/assets/scripts/addComment.js"></script>
 <script type="module" src="/assets/scripts/admin/stateRecipe.js"></script>