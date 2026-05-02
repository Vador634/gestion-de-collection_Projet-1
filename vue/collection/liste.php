<?php
// vue/collection/liste.php
?>
<?php
$pageTitle = "Liste des collections";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Liste des collections</h2>

<!-- Bouton créer nouvelle collection -->
<p>
    <a href="<?= url('Index.php', ['action' => 'creerCollection']) ?>">
        Créer une nouvelle collection
    </a>
</p>

<?php if (empty($collections)): ?>
    <p>Aucune collection trouvée.</p>
<?php else: ?>
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Date création</th>
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
                <td><?= htmlspecialchars($col->dateCreation) ?></td>
                <td><?= htmlspecialchars($col->notePerso) ?></td>
                <td><?= htmlspecialchars($col->idUtilisateur) ?></td>
                <td><?= $nb ?? 0 ?></td>

                <td>
                    <a href="<?= url('Index.php', ['action' => 'detailsCollection', 'id' => $col->idCollection]) ?>">Détails</a> |
                    <a href="<?= url('Index.php', ['action' => 'modifierCollection', 'id' => $col->idCollection]) ?>">Modifier</a> |
                    <a href="<?= url('Index.php', ['action' => 'supprimerCollection', 'id' => $col->idCollection]) ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<div style="margin-top:20px;">
    <a href="<?= url('Index.php') ?>" class="btn">Retour à l'accueil</a>
</div>

<?php include __DIR__ . "/../partials/footer.php"; ?>

