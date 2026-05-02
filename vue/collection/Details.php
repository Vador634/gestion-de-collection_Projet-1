<?php
// vue/collection/details.php
?>
<?php
$pageTitle = "Détails de la collection";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Détails de la collection</h2>

<?php if (!$collection): ?>
    <p>Collection introuvable.</p>
<?php else: ?>
    <p><strong>Id :</strong> <?= htmlspecialchars($collection->idCollection) ?></p>
    <p><strong>Nom :</strong> <?= htmlspecialchars($collection->nomCollection) ?></p>
    <p><strong>Date de création :</strong> <?= htmlspecialchars($collection->dateCreation) ?></p>
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
                 <?= htmlspecialchars($jeu->getTitre()) ?> (<?= htmlspecialchars($jeu->getAnneeSortie()) ?>)
                 <a href="<?= url('Index.php', ['action' => 'detailsJeu', 'id' => $jeu->getIdJeu()]) ?>">Voir</a>
                 <!-- lien pour retirer le jeu si besoin -->
                 <a href="<?= url('Index.php', ['action' => 'retirerJeuCollection', 'id' => $collection->idCollection, 'idJeu' => $jeu->getIdJeu()]) ?>">Retirer</a>
             </li>
         <?php endforeach; ?>
         </ul>
    <?php endif; ?>

    <h3>Ajouter un jeu à cette collection</h3>
    <?php if (!empty($allJeux)): ?>
        <form method="post" action="<?= url('Index.php', ['action' => 'ajouterJeuCollection', 'id' => $collection->idCollection]) ?>">
            <select name="idJeu" required>
                <option value="">-- sélectionner --</option>
                <?php foreach ($allJeux as $j): ?>
                    <option value="<?= $j->getIdJeu() ?>"><?= htmlspecialchars($j->getTitre()) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Ajouter</button>
        </form>
    <?php else: ?>
        <p>Aucun jeu disponible dans la base.</p>
    <?php endif; ?>

    <p>ou <a href="<?= url('Index.php', ['action' => 'ajouterJeu', 'idCollection' => $collection->idCollection]) ?>">
        créer un nouveau jeu et l&apos;ajouter</a>.</p>

    <p><a href="<?= url('Index.php', ['action' => 'modifierCollection', 'id' => $collection->idCollection]) ?>">Modifier la collection</a></p>
    <p><a href="<?= url('Index.php', ['action' => 'listeCollections']) ?>">Retour à la liste</a></p>
<?php endif; ?>

<?php include __DIR__ . "/../partials/footer.php"; ?>

