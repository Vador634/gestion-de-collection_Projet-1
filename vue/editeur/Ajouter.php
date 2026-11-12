<?php include __DIR__ . "/../partials/header.php"; ?>

<?php if (!empty($erreur)): ?>
    <p class="alert alert-error"><?= e($erreur) ?></p>
<?php endif; ?>

<form method="post" action="<?= e(url('index.php', ['action' => 'ajouterEditeur'])) ?>">
    <?= csrf_field() ?>
    <label for="libelleEditeur">Nom de l'éditeur</label>
    <input type="text" id="libelleEditeur" name="libelleEditeur" maxlength="100" value="<?= e($libelleEditeur) ?>" required>
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>

<p><a href="<?= e(url('index.php', ['action' => 'listerEditeurs'])) ?>" class="btn btn-back">← Retour à la liste</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>
