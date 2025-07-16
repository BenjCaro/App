<?php
namespace Carbe\App\Views\Users;

?>

<main class='container p-3 bg-light border-end border-start border-secondary'>
    <h2 class="text-center mb-4">
        Inscription
    </h2>
    <div class="d-flex flex-column w-50 m-auto">
        <form action="/inscription" method="POST" class="form-control pb-2 border-gris bg-gris shadow-sm p-3 mb-5 bg-body-gris rounded" style="--bs-bg-opacity: .5;">
            <div class="mb-3 pt-2">
                    <label for="name" class="form-label text-cacao fw-bold">Nom *</label>
                    <input type="text" name="name" class="form-control" value="<?= isset($_SESSION['old']['name']) ? htmlspecialchars($_SESSION['old']['name']) : ''  ?>" required>
                    <?php if (!empty($_SESSION['errors']['name'])): ?>
                        <div class="alert alert-secondary mt-2"><?= $_SESSION['errors']['name'] ?></div>
                        <?php unset($_SESSION['errors']['name'], $_SESSION['old']['name']); ?>
                    <?php endif; ?>
            </div>
            <div class="mb-3 pt-2">
                    <label for="firstname" class="form-label text-cacao fw-bold">Prénom *</label>
                    <input type="text" name="firstname" class="form-control" value="<?= isset($_SESSION['old']['firstname']) ? htmlspecialchars($_SESSION['old']['firstname']) : ''  ?>" required>
                    <?php if (!empty($_SESSION['errors']['name'])): ?>
                        <div class="alert alert-secondary mt-2"><?= $_SESSION['errors']['name'] ?></div>
                        <?php unset($_SESSION['errors']['name'], $_SESSION['old']['firstname']); ?>
                    <?php endif; ?>
            </div>
            <div class="mb-3 pt-2">
                    <label for="email" class="form-label text-cacao fw-bold">Email *</label>
                    <input type="email" name="email" class="form-control" value="<?= isset($_SESSION['old']['email']) ? htmlspecialchars($_SESSION['old']['email']) : ''  ?>" required>
                    <?php if (!empty($_SESSION['errors']['email'])): ?>
                        <div class="alert alert-secondary mt-2"><?= $_SESSION['errors']['email'] ?></div>
                        <?php unset($_SESSION['errors']['email'], $_SESSION['old']['email']); ?>
                    <?php endif; ?>
            </div>
            <div class="mb-3 pt-2">
                    <label for="password" class="form-label text-cacao fw-bold">Mot de passe *</label>
                    <input type="password" name="password" class="form-control" required>
                    <?php if (!empty($_SESSION['errors']['password'])): ?>
                        <div class="alert alert-secondary mt-2"><?= htmlspecialchars($_SESSION['errors']['password']) ?></div>
                        <?php unset($_SESSION['errors']['password']); ?>
                    <?php endif; ?>
            </div>
            <div class="mb-3 pt-2">
                    <label for="confirm-password" class="form-label text-cacao fw-bold">Confirmez votre mot de passe *</label>
                    <input type="password" name="confirm-password" class="form-control" required>
                    <?php if (!empty($_SESSION['errors']['confirm'])): ?>
                        <div class="alert alert-secondary mt-2"><?= htmlspecialchars($_SESSION['errors']['confirm']) ?></div>
                        <?php unset($_SESSION['errors']['confirm']); ?>
                    <?php endif; ?>
            </div>
            <div class="mb-3 pt-2">
                <label for="description" class="form-label text-cacao fw-bold">Décris toi!</label>
                <textarea name="description" id="description" class="form-control fst-italic" placeholder="J'aime la communauté Petit Creux!"></textarea>

            </div>
            <div class="text-center mb-2">
                <button class="btn btn-secondary" type="submit">Valider</button>
                <button class="btn btn-secondary" type="reset">Effacer</button>
            </div>
            <small class="fst-italic">* champs obligatoires</small>

        </form>
    </div>
</main>
<?php
if (isset($_SESSION['old'])) {
    unset($_SESSION['old']);
}
?>