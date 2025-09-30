<?php 

namespace Carbe\App\Views\Admin;

?>

<main class='container p-3 bg-light'> 
    <h1 class="text-center">
        Ingrédients
    </h1>
    <section class="row d-flex justify-content-center">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ingredients as $ingredient) { ?>
                    <tr>
                        <td><?= htmlspecialchars($ingredient->getName()) ?></td>
                        <td><?= htmlspecialchars($ingredient->getType()) ?></td>
                        
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hiddenForm">
                               Modifier
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-orange" id="deleteIngredient">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="hiddenForm" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Modifier l'ingrédient</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $ingredient->getId() ?>">
                    <div>
                        <label for="">Nom</label>
                        <input type="text" name="name">
                    </div>
                    <div>
                        <label for="">Type</label>
                        <input type="text" name="type">
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Valider</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </section>
</main>
