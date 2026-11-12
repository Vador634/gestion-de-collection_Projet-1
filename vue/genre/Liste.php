<?php /** @var array $genres */ ?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<p><a href="<?= e(url('index.php', ['action' => 'ajouterGenre'])) ?>" class="btn btn-primary">Ajouter un genre</a></p>

<?php if (empty($genres)): ?>
    <p>Aucun élément pour le moment.</p>
<?php else: ?>
    <table>
        <thead><tr><th>Nom</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($genres as $c): ?>
            <tr>
                <td><a href="<?= e(url('index.php', ['action' => 'detailsGenre', 'id' => $c->getIdGenre()])) ?>"><?= e($c->getNomGenre()) ?></a></td>
                
                <td class="actions"><a href="<?= e(url('index.php', ['action' => 'modifierGenre', 'id' => $c->getIdGenre()])) ?>" class="btn btn-secondary btn-sm">Modifier</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include __DIR__ . "/../partials/footer.php"; ?>
