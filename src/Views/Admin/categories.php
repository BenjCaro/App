<?php

namespace Carbe\App\Views\Admin;
use Carbe\App\Services\Flash;

?>

<main class='container p-3 bg-light'> 
     <?php
     $messages = Flash::get();
     foreach($messages as $message) { ?>
        <div class="alert alert-<?= $message['type'] ?>"><?= $message['message']?></div>
    <?php }
    ?>
    <h1 class="text-center">Catégories</h1>
    <section class="row d-flex justify-content-center">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th>Nom</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                     <?php if(!empty($categories)) {
                     foreach($categories as $category) {  ?>
                        <tr>
                            <td><?= htmlspecialchars($category->getName()) ?></td>
                        </tr>
                        
                     <?php   }} ?> 
                    
                </tbody>
            </table>
        </div>
    </section>
</main>