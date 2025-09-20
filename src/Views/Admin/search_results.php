<?php
namespace Carbe\App\Views\Admin;

?>
<main class='container p-3 bg-light'>
    <section class="mb-4 d-flex justify-content-center">
        <form method="get" action="/admin/search" class="w-50">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Recherche" name="q" required>
                <select class="form-select" name="type">
                    <option value="user">Utilisateur</option>
                    <option value="recipe">Recette</option>
                    <option value="category">Catégorie</option>
                </select>
                <button class="btn btn-primary" type="submit">🔍</button>
            </div>
        </form>
   </section>
   <section>
        <?php if ($type === "user"): ?>
            <?php include 'search_users.php'; ?>
        <?php elseif ($type === "recipe"): ?>
            <?php include 'search_recipes.php'; ?>
        <?php elseif ($type === "category"): ?>
            <?php include 'search_categories.php'; ?>
        <?php endif; ?>   
   </section>
    
</main>
