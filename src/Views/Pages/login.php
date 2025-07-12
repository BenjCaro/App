<?php
namespace Carbe\App\Views\Pages;
?>
  <?php  if (isset($_SESSION['flash'])) { ?>
        <div class='alert alert-secondary'><?= $_SESSION['flash'] ?></div>
   <?php     unset($_SESSION['flash']); 
    }
?>
<div class="d-flex flex-column w-25 m-auto">
    <form method="post" action="/login" class="form-control pb-2">
        <div class="mb-3 pt-2">
            <label for="email"  class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
           <label for="password"  class="form-label">Mot de passe</label> 
            <input type="password" name="password" id="password" class="form-control"  required> 
        </div>
        
        <input class="btn btn-secondary" type="submit" value="Connexion">
    </form>
</div>
