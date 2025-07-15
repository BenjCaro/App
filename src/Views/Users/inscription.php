<?php
namespace Carbe\App\Views\Users;

?>


<h2 class="text-center mt-2">
    Inscription
</h2>
<div class="d-flex flex-column w-25 m-auto">
    <form action="/inscription" method="POST" class="form-control pb-2">
        <div class="mb-3 pt-2">
                <label for="name" class="form-label">Nom</label>
                <input type="text" name="name" class="form-control" required>
                 <?php if (!empty($_SESSION['errors']['name'])): ?>
                    <div class="alert alert-secondary mt-2"><?= $_SESSION['errors']['name'] ?></div>
                    <?php unset($_SESSION['errors']['name']); ?>
                <?php endif; ?>
        </div>
        <div class="mb-3 pt-2">
                <label for="firstname" class="form-label">Prénom</label>
                <input type="text" name="firstname" class="form-control" required>
                 <?php if (!empty($_SESSION['errors']['name'])): ?>
                    <div class="alert alert-secondary mt-2"><?= $_SESSION['errors']['name'] ?></div>
                    <?php unset($_SESSION['errors']['name']); ?>
                 <?php endif; ?>
        </div>
        <div class="mb-3 pt-2">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
                 <?php if (!empty($_SESSION['errors']['email'])): ?>
                    <div class="alert alert-secondary mt-2"><?= $_SESSION['errors']['email'] ?></div>
                    <?php unset($_SESSION['errors']['email']); ?>
                <?php endif; ?>
        </div>
        <div class="mb-3 pt-2">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
                <?php if (!empty($_SESSION['errors']['password'])): ?>
                    <div class="alert alert-secondary mt-2"><?= htmlspecialchars($_SESSION['errors']['password']) ?></div>
                    <?php unset($_SESSION['errors']['password']); ?>
                <?php endif; ?>
        </div>
         <div class="mb-3 pt-2">
                <label for="confirm-password" class="form-label">Confirmez votre mot de passe</label>
                <input type="password" name="confirm-password" class="form-control" required>
                <?php if (!empty($_SESSION['errors']['confirm'])): ?>
                    <div class="alert alert-secondary mt-2"><?= htmlspecialchars($_SESSION['errors']['confirm']) ?></div>
                    <?php unset($_SESSION['errors']['password']); ?>
                <?php endif; ?>
        </div>
        <div class="mb-3 pt-2">
            <label for="description" class="form-label">Décris toi!</label>
            <textarea name="description" id="description" class="form-control"></textarea>

        </div>
        <div class="text-center">
            <button class="btn btn-secondary" type="submit">Valider</button>
            <button class="btn btn-secondary" type="reset">Effacer</button>
        </div>

    </form>
</div>