<?php
namespace Carbe\App\Views\Pages;

?>

<main class='container p-3 bg-light'>
     <h2 class="text-center">
        <?= $totalResults ?> résultat<?= $totalResults > 1 ? 's' : '' ?> trouvé<?= $totalResults > 1 ? 's' : '' ?>
        pour « <?= htmlspecialchars($search) ?> »
    </h2>
    <?php if($results) { ?>
        <?php foreach($results as $result) {  ?>
                <div>
                    <h3 class="card-subtitle text-body-secondary fs-4 mt-2 mb-2"> 
                                <?= $result->getTitle()?>
                        </h3>
                        <span class="badge text-bg-secondary"><?= htmlspecialchars($result->getDuration()) . ' minutes' ?></span>
                        <span class="badge text-bg-secondary"><?= $result->getCategory()->getName(); ?></span> <br>
                        <button type="button" class="btn btn-secondary mt-2"><a class="text-black nav-link" href="/recette/<?= $result->getSlug()?>">Voir la recette</a></button>
                </div>
                        <?php } ?>
        
    <?php } else { ?>
         <div>Pas de résultats</div>
     <?php }   ?>
    

</main>
