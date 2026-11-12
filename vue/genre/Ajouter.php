<?php include __DIR__ . "/../partials/header.php"; ?>

<?php if (!empty($erreur)): ?>
    <p class="alert alert-error"><?= e($erreur) ?></p>
<?php endif; ?>

<form method="post" action="<?= e(url('index.php', ['action' => 'ajouterGenre'])) ?>">
    <?= csrf_field() ?>
    <label for="nomGenre">Nom du genre</label>
    <input type="text" id="nomGenre" name="nomGenre" maxlength="100" value="<?= e($nomGenre) ?>" required>
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>

<p><a href="<?= e(url('index.php', ['action' => 'listerGenres'])) ?>" class="btn btn-back">← Retour à la liste</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>
