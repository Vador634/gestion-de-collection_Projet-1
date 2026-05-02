<?php
$pageTitle = "Modifier console";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Modifier une Console</h2>

<?php if (!empty($erreur)): ?>
    <p style="color:red"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<?php if ($console): ?>
<form method="post" action="<?= url('Index.php', ['action' => 'modifierConsole', 'id' => $console->getIdConsole()]) ?>">
    <label>Nom de la console :</label><br>
    <input type="text" name="nomConsole" value="<?= htmlspecialchars($console->getNomConsole()) ?>" required><br><br>

    <label>Fabricant :</label><br>
    <input type="text" name="fabricant" value="<?= htmlspecialchars($console->getFabricant()) ?>" required><br><br>

    <button type="submit">Modifier</button>
</form>
<?php else: ?>
    <p>Console introuvable.</p>
<?php endif; ?>

<a href="<?= url('Index.php', ['action' => 'listerConsoles']) ?>">Retour à la liste</a>

<?php include __DIR__ . "/../partials/footer.php"; ?>
