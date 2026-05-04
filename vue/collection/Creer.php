<?php
/** @var string|null $erreur */

$pageTitle = "Créer une collection";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Créer une collection</h2>

<?php if (!empty($erreur)): ?>
    <p style="color:red"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<form method="post" action="<?= url('Index.php', ['action' => 'creerCollection']) ?>">
    <label>Nom de la collection :</label><br>
    <input type="text" name="nomCollection" required><br><br>

    <label>Note personnelle :</label><br>
    <textarea name="notePerso"></textarea><br><br>

    <button type="submit" class="btn btn-primary">Créer</button>
</form>
<!-- Bouton retour -->
<div style="margin-top:20px;">
    <a href="<?= url('Index.php', ['action' => 'listeCollections']) ?>" class="btn btn-secondary">Retour</a>
</div>
<?php include __DIR__ . "/../partials/footer.php"; ?>
