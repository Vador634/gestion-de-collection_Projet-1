<?php
/** @var string|null $erreur */
/** @var string $nom */
/** @var string $note */
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<?php if (!empty($erreur)): ?>
    <p class="alert alert-error"><?= e($erreur) ?></p>
<?php endif; ?>

<form method="post" action="<?= e(url('index.php', ['action' => 'creerCollection'])) ?>">
    <?= csrf_field() ?>
    <label for="nomCollection">Nom de la collection</label>
    <input type="text" id="nomCollection" name="nomCollection" maxlength="100" value="<?= e($nom) ?>" required>

    <label for="notePerso">Note personnelle (facultatif)</label>
    <textarea id="notePerso" name="notePerso"><?= e($note) ?></textarea>

    <button type="submit" class="btn btn-primary">Créer</button>
</form>

<p><a href="<?= e(url('index.php', ['action' => 'listeCollections'])) ?>" class="btn btn-back">← Retour</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>
