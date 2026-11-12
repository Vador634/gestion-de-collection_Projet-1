<?php /** @var array $editeurs */ ?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<p><a href="<?= e(url('index.php', ['action' => 'ajouterEditeur'])) ?>" class="btn btn-primary">Ajouter un éditeur</a></p>

<?php if (empty($editeurs)): ?>
    <p>Aucun élément pour le moment.</p>
<?php else: ?>
    <table>
        <thead><tr><th>Nom</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($editeurs as $c): ?>
            <tr>
                <td><a href="<?= e(url('index.php', ['action' => 'detailsEditeur', 'id' => $c->idEditeur])) ?>"><?= e($c->libelleEditeur) ?></a></td>
                
                <td class="actions"><a href="<?= e(url('index.php', ['action' => 'modifierEditeur', 'id' => $c->idEditeur])) ?>" class="btn btn-secondary btn-sm">Modifier</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include __DIR__ . "/../partials/footer.php"; ?>
