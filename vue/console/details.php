<?php include("vue/partials/header.php"); ?>
<h1>Détails de la console</h1>

<?php if ($console): ?>
    <p><strong>Nom :</strong> <?php echo htmlspecialchars($console->getNomConsole()); ?></p>
    <p><strong>Constructeur :</strong> <?php echo htmlspecialchars($console->getConstructeur()); ?></p>
<?php else: ?>
    <p>Console introuvable.</p>
<?php endif; ?>

<a href="index.php?action=listerConsoles">← Retour à la liste</a>
<?php include("vue/partials/footer.php"); ?>


