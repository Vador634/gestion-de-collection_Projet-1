<?php
/** @var Jeu[] $jeux */
/** @var array $consolesParJeu consoles de chaque jeu, préparées par le contrôleur */
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<p><a href="<?= e(url('index.php', ['action' => 'ajouterJeu'])) ?>" class="btn btn-primary">Ajouter un jeu</a></p>

<?php if (empty($jeux)): ?>
    <p>Le catalogue est vide.</p>
<?php else: ?>
    <table>
        <thead><tr><th>Titre</th><th>Année</th><th>Consoles</th><th>Prix estimé</th></tr></thead>
        <tbody>
        <?php foreach ($jeux as $jeu):
            $noms = array_map(function ($c) { return $c->getNomConsole(); }, $consolesParJeu[$jeu->getIdJeu()] ?? []);
        ?>
            <tr>
                <td><a href="<?= e(url('index.php', ['action' => 'detailsJeu', 'id' => $jeu->getIdJeu()])) ?>"><?= e($jeu->getTitre()) ?></a></td>
                <td><?= e($jeu->getAnneeSortie() ?: '—') ?></td>
                <td><?= $noms ? e(implode(', ', $noms)) : '—' ?></td>
                <td><?= $jeu->getPrixEstime() !== null ? e(number_format((float)$jeu->getPrixEstime(), 2, ',', ' ')) . ' €' : '—' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include __DIR__ . "/../partials/footer.php"; ?>
