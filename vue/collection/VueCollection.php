<?php
// vue/collection/liste.php
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Liste des collections</h2>

<!-- Bouton créer nouvelle collection -->
<p><a href="index.php?action=creerCollection">Créer une nouvelle collection</a></p>

<?php if (empty($collections)): ?>
    <p>Aucune collection trouvée.</p>
<?php else: ?>
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Date création</th>
                <th>Etat</th>
                <th>Note</th>
                <th>Utilisateur</th>
                <th>Nb jeux</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($collections as $col): 
            $nb = CollectionDAO::countJeux($col->idCollection);
        ?>
            <tr>
                <td><?= htmlspecialchars($col->idCollection) ?></td>
                <td><?= htmlspecialchars($col->nomCollection) ?></td>
                <td><?= htmlspecialchars($col->DateCreation) ?></td>
                <td><?= htmlspecialchars($col->etat) ?></td>
                <td><?= htmlspecialchars($col->notePerso) ?></td>
                <td><?= htmlspecialchars($col->idUtilisateur) ?></td>
                <td><?= $nb ?></td>
                <td>
                    <a href="index.php?action=detailsCollection&id=<?= $col->idCollection ?>">Détails</a> |
                    <a href="index.php?action=modifierCollection&id=<?= $col->idCollection ?>">Modifier</a> |
                    <a href="index.php?action=supprimerCollection&id=<?= $col->idCollection ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<!-- Bouton retour -->
<div style="margin-top:20px;">
    <a href="/~kcarasco/Gestion_de_collection/Index.php" class="btn">Retour à l'accueil</a>
</div>

<?php include __DIR__ . "/../partials/footer.php"; ?>
