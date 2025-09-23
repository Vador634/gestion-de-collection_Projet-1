<h2>Détails du Jeu</h2>
<?php if ($jeu): ?>
    <p><strong>Titre :</strong> <?= htmlspecialchars($jeu->titre) ?></p>
    <p><strong>Année de sortie :</strong> <?= htmlspecialchars($jeu->anneeSortie) ?></p>
    <p><strong>Prix estimé :</strong> <?= htmlspecialchars($jeu->prixEstime) ?> €</p>
<?php else: ?>
    <p>Jeu introuvable.</p>
<?php endif; ?>
<a href="index.php?action=listeJeux">Retour à la liste</a>
