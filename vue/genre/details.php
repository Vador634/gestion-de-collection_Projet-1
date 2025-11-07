<?php include("vue/partials/header.php"); ?>
<h1>Détails du Genre</h1>

<?php if ($genre): ?>
    <p><strong>Nom :</strong> <?php echo htmlspecialchars($genre->getNomGenre()); ?></p>
<?php else: ?>
    <p>Genre introuvable.</p>
<?php endif; ?>

<a href="index.php?action=listerGenres">← Retour à la liste</a>
<?php include("vue/partials/footer.php"); ?>
