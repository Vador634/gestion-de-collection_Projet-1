<?php
/** @var Collection $collection */
/** @var string|null $erreur */

$pageTitle = "Modifier une collection";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Modifier une collection</h2>

<?php if (!empty($erreur)): ?>
    <p style="color:red"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<?php if ($collection): ?>
<form method="post" action="<?= url('Index.php', ['action' => 'modifierCollection', 'id' => $collection->idCollection]) ?>">
    <label>Nom de la collection :</label><br>
    <input type="text" name="nomCollection" value="<?= htmlspecialchars($collection->nomCollection) ?>" required><br><br>

    <label>Note personnelle :</label><br>
    <textarea name="notePerso"><?= htmlspecialchars($collection->notePerso) ?></textarea><br><br>

    <button type="submit" class="btn btn-primary">Modifier</button>
</form>
<?php else: ?>
    <p>Collection introuvable.</p>
<?php endif; ?>

<!-- Bouton retour -->
<div style="margin-top:20px;">
    <a href="<?= url('Index.php', ['action' => 'listeCollections']) ?>" class="btn btn-secondary">Retour</a>
</div>
<?php include __DIR__ . "/../partials/footer.php"; ?>
