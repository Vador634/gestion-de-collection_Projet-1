<?php /** @var array $consoles */ ?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<p><a href="<?= e(url('index.php', ['action' => 'ajouterConsole'])) ?>" class="btn btn-primary">Ajouter une console</a></p>

<?php if (empty($consoles)): ?>
    <p>Aucun élément pour le moment.</p>
<?php else: ?>
    <table>
        <thead><tr><th>Nom</th><th>Fabricant</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($consoles as $c): ?>
            <tr>
                <td><a href="<?= e(url('index.php', ['action' => 'detailsConsole', 'id' => $c->getIdConsole()])) ?>"><?= e($c->getNomConsole()) ?></a></td>
                <td><?= e($c->getFabricant()) ?></td>
                <td class="actions"><a href="<?= e(url('index.php', ['action' => 'modifierConsole', 'id' => $c->getIdConsole()])) ?>" class="btn btn-secondary btn-sm">Modifier</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include __DIR__ . "/../partials/footer.php"; ?>
