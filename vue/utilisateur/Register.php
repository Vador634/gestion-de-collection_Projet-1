<?php
/** @var string|null $erreur */
$pageTitle = "Inscription";
$ancien = function ($champ) {
    return e(is_string($_POST[$champ] ?? null) ? $_POST[$champ] : '');
};
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<?php if (!empty($erreur)): ?>
    <p class="alert alert-error"><?= e($erreur) ?></p>
<?php endif; ?>

<form method="post" action="<?= e(url('index.php', ['action' => 'register'])) ?>">
    <?= csrf_field() ?>
    <label for="nom">Nom</label>
    <input type="text" id="nom" name="nom" maxlength="50" value="<?= $ancien('nom') ?>" autocomplete="family-name" required>

    <label for="prenom">Prénom</label>
    <input type="text" id="prenom" name="prenom" maxlength="50" value="<?= $ancien('prenom') ?>" autocomplete="given-name" required>

    <label for="pseudo">Pseudo</label>
    <input type="text" id="pseudo" name="pseudo" maxlength="50" value="<?= $ancien('pseudo') ?>" autocomplete="nickname" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" maxlength="100" value="<?= $ancien('email') ?>" autocomplete="email" required>

    <label for="motDePasse">Mot de passe (8 caractères minimum)</label>
    <input type="password" id="motDePasse" name="motDePasse" minlength="8" autocomplete="new-password" required>

    <button type="submit" class="btn btn-primary">Créer mon compte</button>
</form>

<p>Déjà inscrit ? <a href="<?= e(url('index.php', ['action' => 'login'])) ?>">Connectez-vous</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>
