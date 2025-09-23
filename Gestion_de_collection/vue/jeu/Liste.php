<h2>Liste des Jeux</h2>
<ul>
<?php foreach ($jeux as $jeu): ?>
    <li>
        <?= htmlspecialchars($jeu->titre) ?> (<?= htmlspecialchars($jeu->anneeSortie) ?>) - <?= htmlspecialchars($jeu->prixEstime) ?>€
        <a href="index.php?action=detailsJeu&id=<?= $jeu->idJeu ?>">Détails</a>
    </li>
<?php endforeach; ?>
</ul>
<a href="index.php?action=ajouterJeu">Ajouter un jeu</a>

