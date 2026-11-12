<?php include __DIR__ . "/../partials/header.php"; ?>

<?php if (!empty($erreur)): ?>
    <p class="alert alert-error"><?= e($erreur) ?></p>
<?php endif; ?>

<form method="post" action="<?= e(url('index.php', ['action' => 'modifierConsole', 'id' => $console->getIdConsole()])) ?>">
    <?= csrf_field() ?>
    <label for="nomConsole">Nom de la console</label>
    <input type="text" id="nomConsole" name="nomConsole" maxlength="100" value="<?= e($console->getNomConsole()) ?>" required>
    <label for="fabricant">Fabricant</label>
    <input type="text" id="fabricant" name="fabricant" maxlength="100" value="<?= e($console->getFabricant()) ?>" required>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>

<p><a href="<?= e(url('index.php', ['action' => 'detailsConsole', 'id' => $console->getIdConsole()])) ?>" class="btn btn-back">← Retour</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>
