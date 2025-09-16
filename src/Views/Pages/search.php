<?php
namespace Carbe\App\Views\Pages;

use Carbe\App\Models\SearchModel;
use Carbe\App\Models\RecipeModel;

/** @var \Carbe\App\Models\RecipeModel[] $results  */
/** @var int $totalResults nombre de résultats */
/** @var string $search recherche de l'utilisateur */
?>

<main class='container p-3 bg-light'>
     <h2 class="text-center">
        <?= $totalResults ?> résultat<?= $totalResults > 1 ? 's' : '' ?> trouvé<?= $totalResults > 1 ? 's' : '' ?>
        pour « <?= htmlspecialchars($search) ?> »
    </h2>
    <?php if($results) { ?>
        <div class="row g-3">
            <?php foreach($results as $result) {  ?>
                <div class="col-md-4">
                    <div class="card h-100 bg-white border border-secondary p-2 d-flex flex-column justify-content-end">
                        <h3 class="card-subtitle text-body-secondary fs-4 mt-2 mb-2"> 
                            <?= $result->getTitle()?>
                        </h3>
                        <span class="badge text-bg-secondary mb-1"><?= htmlspecialchars(strval($result->getDuration())) . ' minutes' ?></span>
                        <span class="badge text-bg-secondary"><?= $result->getCategory()->getName(); ?></span> <br>
                        <button type="button" class="btn btn-primary mt-2"><a class="text-black nav-link" href="/recette/<?= $result->getSlug()?>">Voir la recette</a></button>
                    </div>
                </div>      
            <?php } ?>
        </div>
        
    <?php } else { ?>
         <div class="text-center">Aucun résultat.</div>
     <?php }   ?>
    

</main>
