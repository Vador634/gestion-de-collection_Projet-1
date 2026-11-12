<?php include __DIR__ . "/../partials/header.php"; ?>

<?php if (!empty($erreur)): ?>
    <p class="alert alert-error"><?= e($erreur) ?></p>
<?php endif; ?>

<form method="post" action="<?= e(url('index.php', ['action' => 'ajouterConsole'])) ?>">
    <?= csrf_field() ?>
    <label for="nomConsole">Nom de la console</label>
    <input type="text" id="nomConsole" name="nomConsole" maxlength="100" value="<?= e($nomConsole) ?>" required>
    <label for="fabricant">Fabricant</label>
    <input type="text" id="fabricant" name="fabricant" maxlength="100" value="<?= e($fabricant) ?>" required>
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>

<p><a href="<?= e(url('index.php', ['action' => 'listerConsoles'])) ?>" class="btn btn-back">← Retour à la liste</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>
