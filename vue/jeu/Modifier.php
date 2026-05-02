<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Modifier un Jeu</h2>

<?php if (!empty($erreur)): ?>
    <p style="color:red"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<?php if ($jeu): ?>
<form method="post" action="<?= url('Index.php', ['action' => 'modifierJeu', 'id' => $jeu->getIdJeu()]) ?>">
    <label>Titre :</label><br>
    <input type="text" name="titre" value="<?= htmlspecialchars($jeu->getTitre()) ?>" required><br><br>

    <label>Année de sortie :</label><br>
    <input type="date" name="anneeSortie" value="<?= htmlspecialchars($jeu->getAnneeSortie()) ?>" required><br><br>

    <label>Prix estimé :</label><br>
    <input type="number" step="0.01" name="prixEstime" value="<?= htmlspecialchars($jeu->getPrixEstime()) ?>" required><br><br>

    <button type="submit">Modifier</button>
</form>
<?php else: ?>
    <p>Jeu introuvable.</p>
<?php endif; ?>

<a href="<?= url('Index.php', ['action' => 'listeJeux']) ?>">Retour à la liste</a>

<?php include __DIR__ . "/../partials/footer.php"; ?>
