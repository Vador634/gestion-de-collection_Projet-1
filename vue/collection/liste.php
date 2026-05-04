<?php
/** @var Collection[] $collections */
/** @var array $counts */

$pageTitle = "Liste des collections";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Liste des collections</h2>

<!-- Bouton créer nouvelle collection -->
<p>
    <a href="<?= url('Index.php', ['action' => 'creerCollection']) ?>" class="btn btn-primary">
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
            $nb = $counts[$col->idCollection] ?? 0;
        ?>
            <tr>
                <td><?= htmlspecialchars($col->idCollection) ?></td>
                <td><?= htmlspecialchars($col->nomCollection) ?></td>
                <td><?= htmlspecialchars($col->dateCreation) ?></td>
                <td><?= htmlspecialchars((string)$col->notePerso) ?></td>
                <td><?= htmlspecialchars($col->idUtilisateur) ?></td>
                <td><?= $nb ?? 0 ?></td>

                <td>
                    <a href="<?= url('Index.php', ['action' => 'detailsCollection', 'id' => $col->idCollection]) ?>" class="btn btn-secondary btn-sm">Détails</a>
                    <a href="<?= url('Index.php', ['action' => 'modifierCollection', 'id' => $col->idCollection]) ?>" class="btn btn-secondary btn-sm">Modifier</a>
                    <a href="<?= url('Index.php', ['action' => 'supprimerCollection', 'id' => $col->idCollection]) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<div style="margin-top:20px;">
    <a href="<?= url('Index.php') ?>" class="btn btn-secondary">Retour à l'accueil</a>
</div>

<?php include __DIR__ . "/../partials/footer.php"; ?>
