<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Ajouter une Console</h2>

<?php if (!empty($erreur)): ?>
    <p style="color:red"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<form method="post" action="<?= url('Index.php', ['action' => 'ajouterConsole']) ?>">
    <label>Nom de la console :</label><br>
    <input type="text" name="nomConsole" required><br><br>

    <label>Fabricant :</label><br>
    <input type="text" name="fabricant" required><br><br>

    <button type="submit">Ajouter</button>
</form>

<a href="<?= url('Index.php', ['action' => 'listerConsoles']) ?>">Retour à la liste</a>

<?php include __DIR__ . "/../partials/footer.php"; ?>
