<?php
$pageTitle = "Ajouter un genre";
?><?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Ajouter un Genre</h2>

<?php if (!empty($erreur)): ?>
    <p style="color:red"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<form method="post" action="<?= url('Index.php', ['action' => 'ajouterGenre']) ?>">
    <label>Nom du genre :</label><br>
    <input type="text" name="nomGenre" required><br><br>

    <button type="submit">Ajouter</button>
</form>

<a href="<?= url('Index.php', ['action' => 'listerGenres']) ?>">Retour à la liste</a>

<?php include __DIR__ . "/../partials/footer.php"; ?>
