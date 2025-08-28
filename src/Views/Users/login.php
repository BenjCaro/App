<?php
namespace Carbe\App\Views\Pages;
use Carbe\App\Services\Flash;
?>


<main class='container p-3 bg-light'>
    <?php
     $flash = Flash::get();
     if($flash) { ?>
        <div class="alert alert-<?= $flash['type'] ?>"><?= $flash['message']?></div>
    <?php }
    ?>
    <h2 class="text-center mb-2">Connexion</h2>  
    <div class="d-flex flex-column w-25 m-auto">
        <form method="post" action="/login" class="form-control p-3 border-gris bg-gris shadow-sm p-3 mb-5 bg-body-gris rounded" style="--bs-bg-opacity: .5;">
            <div class="mb-3 pt-2">
                <label for="email"  class="form-label">Email</label>
                <input type="email" value="<?=  $old['email'] ?? ''   ?>" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
            <label for="password"  class="form-label">Mot de passe</label> 
                <input type="password" name="password" id="password" class="form-control"  required> 
            </div>
            <div class="d-flex flex-column">
                <button class="btn btn-primary" type="submit">Se Connecter</button>
                <span class="text-center">ou</span>
                <button class="btn btn-secondary"><a class="nav-link" href="/inscription">Rejoindre Petit Creux!</a></button>
            </div>
            
        </form>
    </div>
</main>
