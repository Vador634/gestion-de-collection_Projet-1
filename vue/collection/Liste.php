<?php
/** @var Collection[] $collections */
/** @var array $counts nombre de jeux par collection */
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<p><a href="<?= e(url('index.php', ['action' => 'creerCollection'])) ?>" class="btn btn-primary">Créer une nouvelle collection</a></p>

<?php if (empty($collections)): ?>
    <p>Vous n'avez pas encore de collection.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Créée le</th>
                <th>Jeux</th>
                <th>Note</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($collections as $col): ?>
            <tr>
                <td><a href="<?= e(url('index.php', ['action' => 'detailsCollection', 'id' => $col->idCollection])) ?>"><?= e($col->nomCollection) ?></a></td>
                <td><?= e(date('d/m/Y', strtotime($col->dateCreation))) ?></td>
                <td><?= (int)($counts[$col->idCollection] ?? 0) ?></td>
                <td><?= e(extrait((string)$col->notePerso, 60)) ?></td>
                <td class="actions">
                    <a href="<?= e(url('index.php', ['action' => 'detailsCollection', 'id' => $col->idCollection])) ?>" class="btn btn-secondary btn-sm">Détails</a>
                    <a href="<?= e(url('index.php', ['action' => 'modifierCollection', 'id' => $col->idCollection])) ?>" class="btn btn-secondary btn-sm">Modifier</a>
                    <?php
                        $supprAction = 'supprimerCollection';
                        $supprParams = ['id' => $col->idCollection];
                        $supprLibelle = 'Supprimer';
                        $supprConfirmation = "Supprimer la collection « {$col->nomCollection} » ? Les jeux restent dans le catalogue.";
                        include __DIR__ . "/../partials/bouton_supprimer.php";
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include __DIR__ . "/../partials/footer.php"; ?>
