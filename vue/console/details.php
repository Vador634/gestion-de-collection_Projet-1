<?php
$pageTitle = "Détails console";
?><?php include __DIR__ . "/../partials/header.php"; ?>

<h1>Détails de la console</h1>

<?php if ($console): ?>
    <p><strong>Nom :</strong> <?php echo htmlspecialchars($console->getNomConsole()); ?></p>
    <p><strong>Fabricant :</strong> <?php echo htmlspecialchars($console->getFabricant()); ?></p>
<?php else: ?>
    <p>Console introuvable.</p>
<?php endif; ?>

<a href="<?= url('Index.php', ['action' => 'listerConsoles']) ?>">← Retour à la liste</a>

<?php include __DIR__ . "/../partials/footer.php"; ?>
