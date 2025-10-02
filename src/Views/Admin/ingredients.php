<?php 

namespace Carbe\App\Views\Admin;

use Carbe\App\Services\Csrf;
use Carbe\App\Services\Flash;
?>

<main class='container p-3 bg-light'> 
    <?php
     $messages = Flash::get();
     foreach($messages as $message) { ?>
        <div class="alert alert-<?= $message['type'] ?>"><?= $message['message']?></div>
    <?php }
    ?>
    <h1 class="text-center">
        Ingrédients
    </h1>
    <section>
      <!-- Rechercher un ingrédient ;) -->
    </section>
    <section class="row d-flex flex-column align-items-center justify-content-center gap-2">
      <h2 class="text-center">Créer un ingrédient</h2>
        <form action="/admin/insert-ingredient" method="POST" class="bg-gris card col-6 mb-3">
            <?php $tokenC = Csrf::get("create_ingredient") ?>
            <input type="hidden" name="_token" value="<?= $tokenC ?>">
           <div class="card-body">
                <div class="mb-2">
                    <label for="">Nom</label>
                    <input type="text" name="name" class="form-control" required>
                    <?php $nameErrors = Flash::showErrorsForm("name");
                      foreach($nameErrors as $nameError) { ?>
                        <div class="alert alert-<?= $nameError['type'] ?> mt-2"><?= $nameError['message'] ?></div>
                    <?php   } ?>
                </div>
                <div class="mb-2">
                    <label for="">Type</label>
                    <select name="type" id="" class="form-select" required>
                        <option value="fruits">Fruits</option>
                        <option value="legumes">Légumes</option>
                        <option value="cereales">Céréales</option>
                        <option value="legumineuses">Légumineuses</option>
                        <option value="viandes">Viandes</option>
                        <option value="poissons">Poissons</option>
                        <option value="oeufs">Oeufs</option>
                        <option value="laitier">Produits Laitiers</option>
                        <option value="huiles">Huiles</option>
                        <option value="sucres">Sucrés</option>
                        <option value="sauces">Sauces</option>
                    </select>
                    <?php $typeErrors = Flash::showErrorsForm("name");
                      foreach($typeErrors as $typeError) { ?>
                        <div class="alert alert-<?= $typeError['type'] ?> mt-2"><?= $typeError['message'] ?></div>
                    <?php   } ?>
                </div>
                 <div class="d-flex justify-content-center mb-2 gap-2">
                    <button type="submit" id="" class="btn btn-sm btn-primary">Valider la création</button>
                </div>
           </div>
        </form>
    </section>
    <section class="row d-flex justify-content-center">
        <h2 class="text-center">Tout les ingrédients</h2>
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hiddenForm" 
                              data-id= "<?= $ingredient->getId() ?>" data-name="<?= htmlspecialchars($ingredient->getName()) ?>" data-type="<?= htmlspecialchars($ingredient->getType()) ?>">
                               Modifier
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-orange" data-bs-toggle="modal" data-bs-target="#hiddenDeleteForm" data-id= "<?= $ingredient->getId() ?>">
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
                        <h3 class="modal-title">Modifier l'ingrédient</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/admin/update-ingredient" method="post" id="updateForm">
                            <?php $token = Csrf::get("update_ingredient"); ?>
                            <input type="hidden" name="_token" value="<?= $token ?>">
                            <input type="hidden"  name="id" value="">
                            <div class="mb-3">
                                <label for="ingredientName" class="form-label">Nom</label>
                                <input type="text" id="ingredientName" name="name" class="form-control" value="">
                            </div>
                            <div class="mb-3">
                                <label for="ingredientType" class="form-label">Type</label>
                                <select class="form-select" name="type" value="">
                                    <option value="fruits">Fruits</option>
                                        <option value="legumes">Légumes</option>
                                        <option value="cereales">Céréales</option>
                                        <option value="legumineuses">Légumineuses</option>
                                        <option value="viandes">Viandes</option>
                                        <option value="poissons">Poissons</option>
                                        <option value="oeufs">Oeufs</option>
                                        <option value="laitier">Produits Laitiers</option>
                                        <option value="huiles">Huiles</option>
                                        <option value="sucres">Sucrés</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="hiddenDeleteForm" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Supprimer l'ingrédient</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/admin/delete-ingredient" method="POST" id="deleteForm">
                            <?php $tokenD = Csrf::get("delete_ingredient")?>
                            <input type="hidden" name="_token" value="<?= $tokenD ?>">
                            <input type="hidden" name="id" value="">
                            <p>Es-tu sûr de vouloir supprimer cet ingrédient ?</p>
                            <div class="mt-3 d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Supprimer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="/assets/scripts/Admin/adminIngredient.js" type="text/javascript"></script>

