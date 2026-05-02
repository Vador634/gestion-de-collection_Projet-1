<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Ajouter un Jeu</h2>

<?php if (!empty($erreur)): ?>
    <p style="color:red"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<form method="post" action="<?= url('Index.php', ['action' => 'ajouterJeu']) ?>">
    <label>Titre :</label><br>
    <input type="text" name="titre" required><br><br>

    <label>Année de sortie :</label><br>
    <input type="date" name="anneeSortie" required><br><br>

    <label>Prix estimé :</label><br>
    <input type="number" step="0.01" name="prixEstime" required><br><br>

    <button type="submit">Ajouter</button>
</form>

<a href="<?= url('Index.php', ['action' => 'listeJeux']) ?>">Retour à la liste</a>

<?php include __DIR__ . "/../partials/footer.php"; ?>
