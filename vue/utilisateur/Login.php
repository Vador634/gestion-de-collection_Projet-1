<?php
/** @var string|null $erreur */
$pageTitle = "Connexion";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<?php if (!empty($erreur)): ?>
    <p class="alert alert-error"><?= e($erreur) ?></p>
<?php endif; ?>

<form method="post" action="<?= e(url('index.php', ['action' => 'login'])) ?>">
    <?= csrf_field() ?>
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" autocomplete="email" required>

    <label for="motDePasse">Mot de passe</label>
    <input type="password" id="motDePasse" name="motDePasse" autocomplete="current-password" required>

    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>

<p>Pas encore de compte ? <a href="<?= e(url('index.php', ['action' => 'register'])) ?>">Inscrivez-vous</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>
