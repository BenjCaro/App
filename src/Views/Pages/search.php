<?php
namespace Carbe\App\Views\Pages;

?>

<main class='container p-3 bg-light'>
    <?php if($results) { ?>
        <?php foreach($results as $result) {  ?>

        <?php } ?>
    <?php } else { ?>
         <div>Pas de résultats</div>
     <?php }   ?>
    

</main>
