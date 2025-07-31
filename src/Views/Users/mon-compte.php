<?php
namespace Carbe\App\Views\Pages;

if (!isset($_SESSION['auth_user'])) {
    $_SESSION['flash'] = "Connectez-vous pour accèder à cette page!";
    header('Location: /login');
    exit();
}

if (isset($_SESSION['errors']['database'])) {
    echo $_SESSION['errors']['database'];
    unset($_SESSION['errors']['database']); 
}

?>

<main class='container p-3 bg-light border-end border-start border-secondary'>
    <?php
     if (isset($_SESSION['flash'])) {  ?>
       <div class='alert alert-primary'><?=$_SESSION['flash']?></div>
    <?php    unset($_SESSION['flash']); 
    }


    if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) { ?>
    <div class="alert alert-secondary">
    <?php foreach ($_SESSION['errors'] as $error) { ?>
            <?= htmlspecialchars($error) ?>
    <?php } ?>
            
    </div>
        <?php unset($_SESSION['errors']); 
    }

    ?>
    <h2 class="text-center">Bienvenue sur votre espace <?= $user->getFirstname()?> </h2>
    <section class="row d-flex justify-content-center">
        <h3 class="text-center">Mes informations</h3>
        <form class="card col-6" id="formInformation" action="/mon-compte/update-profil" method="POST">
            <div class="card-body">
                <div class="mb-2">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" id="name" name="name" class="form-control bg-gris" value="<?= $user->getName(); ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="firstname" class="form-label">Prénom</label>
                    <input type="text" class="form-control bg-gris" name="firstname" id="firstname" value="<?= $user->getFirstname(); ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control bg-gris" value="<?= $user->getEmail(); ?>" readonly>
                </div>
                 <div class="d-flex justify-content-center mb-2">
                    <button type="button" id="editInformation" class="btn btn-sm btn-primary">Modifier mes informations</button>
                </div>
            </div>    
        </form>
        <form class="card col-6" id="formDescription" action="/mon-compte/update-description" method="POST">
            <div class="card-body">
                <div class="mb-2">
                    <label for="membership" class="form-label">Membre depuis</label>
                    <input type="text" class="form-control bg-gris" name="membership" id="membership" value="<?= $user->getCreatedAt() ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="description" class="form-label">Ma description</label>
                    <textarea id="description" class="form-control bg-gris" name="description" rows="4" readonly><?= $user->getDescription() ? $user->getDescription() : "Rédigez votre description."?></textarea>
                </div>
                <div class="d-flex justify-content-center mb-2">
                    <button type="button" id="editDescription" class="btn btn-sm btn-primary">Modifier ma description</button>
                </div>
            </div>
        </form>
    </section>
    <section class="row d-flex justify-content-center">
        <h3 class="text-center mt-4 mb-4">Mes favoris</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Catégorie</th>
                        <th>Titre</th>
                        <th>Lien</th>
                        <th>Supprimer des favoris</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($favoris as $recipe) { ?>
                    <tr>
                        <td><?= htmlspecialchars($recipe->getCategory()->getName())?></td>
                        <td><?= htmlspecialchars($recipe->getTitle()) ?></td>
                        <td><a href="/recette/<?= urlencode($recipe->getSlug()) ?>" class="btn btn-sm btn-outline-primary">Consulter</a></td>
                        <td>
                            <form method="POST" action="/mon-compte/suppr-favoris" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer des favoris ?');">
                                <input type="hidden" name="favoris" value="<?= $recipe->getId()?>">
                                <button type="submit" class="btn btn-sm btn-secondary">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
    <section class="row d-flex justify-content-center">
        <h3 class="text-center mt-4 mb-4">Mes recettes ajoutées</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Catégorie</th>
                    <th>Titre</th>
                    <th>Lien</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($userRecipes as $userRecipe) { ?>
                    <tr>
                        <td><?= htmlspecialchars($userRecipe->getCategory()->getName()) ?></td>
                        <td><?= htmlspecialchars($userRecipe->getTitle()) ?></td>
                        <td><a href="/recette/<?= urlencode($userRecipe->getSlug()) ?>" class="btn btn-sm btn-outline-primary">Consulter</a></td>
                        <td>
                           <button type="submit" class="btn btn-sm btn-primary"><a href="/update/recette/<?= urlencode($userRecipe->getSlug()) ?>" class="nav-link">Modifier</a></button>
                        </td>
                        <td>
                            <form method="POST" action="/mon-compte/suppr-recette" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?');">
                                <input type="hidden" name="recipe" value="<?= $userRecipe->getId()?>">
                                <button type="submit" class="btn btn-sm btn-secondary">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php  } ?>
                <!-- Afficher les recettes ajoutées par l'utilisateur modifier/supprimer -->
            </tbody>
            </table>
        </div>
    </section>
    <section class="row d-flex justify-content-center">
        Mes commentaires
<!-- Afficher les commentaires ajoutés par l'utilisateur modifier/supprimer -->
<!-- utiliser meme structure tableau que favoris -->
    </section>
</main>
<script>
    const updateBtn = document.getElementById("editInformation");
    const inputs = document.querySelectorAll('input');
    

    updateBtn.addEventListener('click', (event) => {
    event.preventDefault();

      if(!editing) {

        editing= true;
        updateBtn.classList.remove("btn-primary");
        updateBtn.classList.add("btn-secondary");
        inputs.forEach(input => {
        input.removeAttribute('readonly');
        input.classList.remove('bg-gris');
          
    })

    } else {
        
        formInformation.requestSubmit();
        
        }
    });

    formInformation.addEventListener('submit', (event) => {
            event.preventDefault(); 
            confirm('Etes vous sur de valider vos modifications?');
            formInformation.submit();
            console.log('Informations soumises');
     });
 
</script>
<script type="text/javascript" src="/assets/scripts/updateUserDescription.js"></script>




