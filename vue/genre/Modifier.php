<?php
$pageTitle = "Modifier un genre";
?><?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Modifier un Genre</h2>

<?php if (!empty($erreur)): ?>
    <p style="color:red"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<?php if ($genre): ?>
<form method="post" action="<?= url('Index.php', ['action' => 'modifierGenre', 'id' => $genre->getIdGenre()]) ?>">
    <label>Nom du genre :</label><br>
    <input type="text" name="nomGenre" value="<?= htmlspecialchars($genre->getNomGenre()) ?>" required><br><br>

    <button type="submit">Modifier</button>
</form>
<?php else: ?>
    <p>Genre introuvable.</p>
<?php endif; ?>

<a href="<?= url('Index.php', ['action' => 'listerGenres']) ?>">Retour à la liste</a>

<?php include __DIR__ . "/../partials/footer.php"; ?>
