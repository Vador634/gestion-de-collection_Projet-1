<?php include __DIR__ . "/../partials/header.php"; ?>

<?php if (!empty($erreur)): ?>
    <p class="alert alert-error"><?= e($erreur) ?></p>
<?php endif; ?>

<form method="post" action="<?= e(url('index.php', ['action' => 'modifierEditeur', 'id' => $editeur->idEditeur])) ?>">
    <?= csrf_field() ?>
    <label for="libelleEditeur">Nom de l'éditeur</label>
    <input type="text" id="libelleEditeur" name="libelleEditeur" maxlength="100" value="<?= e($editeur->libelleEditeur) ?>" required>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>

<p><a href="<?= e(url('index.php', ['action' => 'detailsEditeur', 'id' => $editeur->idEditeur])) ?>" class="btn btn-back">← Retour</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>
