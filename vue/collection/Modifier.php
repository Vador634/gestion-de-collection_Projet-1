<?php
/** @var Collection $collection */
/** @var string|null $erreur */
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<?php if (!empty($erreur)): ?>
    <p class="alert alert-error"><?= e($erreur) ?></p>
<?php endif; ?>

<form method="post" action="<?= e(url('index.php', ['action' => 'modifierCollection', 'id' => $collection->idCollection])) ?>">
    <?= csrf_field() ?>
    <label for="nomCollection">Nom de la collection</label>
    <input type="text" id="nomCollection" name="nomCollection" maxlength="100" value="<?= e($collection->nomCollection) ?>" required>

    <label for="notePerso">Note personnelle</label>
    <textarea id="notePerso" name="notePerso"><?= e($collection->notePerso) ?></textarea>

    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>

<p><a href="<?= e(url('index.php', ['action' => 'detailsCollection', 'id' => $collection->idCollection])) ?>" class="btn btn-back">← Retour</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>
