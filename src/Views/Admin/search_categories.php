<?php

namespace Carbe\App\Views\Admin;

if (!empty($results)) : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Nombre de recettes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $category) : ?>
                        <tr>
                            <td><?= htmlspecialchars($category->getName()) ?></td>
                            <td><?= $category->getTotalRecipes() ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p class="text-center">Aucun utilisateur trouvé.</p>
    <?php endif; ?>
</section>