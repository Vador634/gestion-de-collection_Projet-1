<?php
// vue/collection/details.php
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Détails de la collection</h2>

<?php if (!$collection): ?>
    <p>Collection introuvable.</p>
<?php else: ?>
    <p><strong>Id :</strong> <?= htmlspecialchars($collection->idCollection) ?></p>
    <p><strong>Nom :</strong> <?= htmlspecialchars($collection->nomCollection) ?></p>
    <p><strong>Date de création :</strong> <?= htmlspecialchars($collection->DateCreation) ?></p>
    <p><strong>Etat :</strong> <?= htmlspecialchars($collection->etat) ?></p>
    <p><strong>Note perso :</strong> <?= nl2br(htmlspecialchars($collection->notePerso)) ?></p>
    <p><strong>Propriétaire (id) :</strong> <?= htmlspecialchars($collection->idUtilisateur) ?></p>
    <p><strong>Nombre de jeux :</strong> <?= $nbJeux ?></p>

    <h3>Jeux dans cette collection</h3>
    <?php if (empty($jeux)): ?>
        <p>Pas de jeux.</p>
    <?php else: ?>
        <ul>
        <?php foreach ($jeux as $jeu): ?>
            <li>
                <?= htmlspecialchars($jeu->titre) ?> (<?= htmlspecialchars($jeu->anneeSortie) ?>)
                <a href="index.php?action=detailsJeu&id=<?= $jeu->idJeu ?>">Voir</a>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p><a href="index.php?action=modifierCollection&id=<?= $collection->idCollection ?>">Modifier la collection</a></p>
    <p><a href="index.php?action=listeCollections">Retour à la liste</a></p>
<?php endif; ?>

<?php include __DIR__ . "/../partials/footer.php"; ?>

