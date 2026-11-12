<?php
/** @var Jeu $jeu */
/** @var Console[] $consoles  @var Genre[] $genres  @var Editeur[] $editeurs */
/** @var Condition|null $condition  @var Rarete|null $rarete  @var Developpeur|null $developpeur */
/** @var int $nbCollections */
$noms = function ($liste, $getter) {
    return implode(', ', array_map(function ($o) use ($getter) { return is_callable([$o, $getter]) ? $o->$getter() : $o->$getter; }, $liste));
};
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<table class="fiche">
    <tr><th>Titre</th><td><?= e($jeu->getTitre()) ?></td></tr>
    <tr><th>Année de sortie</th><td><?= e($jeu->getAnneeSortie() ?: '—') ?></td></tr>
    <tr><th>Prix estimé</th><td><?= $jeu->getPrixEstime() !== null ? e(number_format((float)$jeu->getPrixEstime(), 2, ',', ' ')) . ' €' : '—' ?></td></tr>
    <tr><th>État</th><td><?= $condition ? e($condition->libelleCondition) : '—' ?></td></tr>
    <tr><th>Rareté</th><td><?= $rarete ? e($rarete->libelleRarete) : '—' ?></td></tr>
    <tr><th>Développeur</th><td><?= $developpeur ? e($developpeur->libelleDeveloppeur) : '—' ?></td></tr>
    <tr><th>Consoles</th><td><?= $consoles ? e($noms($consoles, 'getNomConsole')) : '—' ?></td></tr>
    <tr><th>Genres</th><td><?= $genres ? e($noms($genres, 'getNomGenre')) : '—' ?></td></tr>
    <tr><th>Éditeurs</th><td><?= $editeurs ? e($noms($editeurs, 'libelleEditeur')) : '—' ?></td></tr>
    <tr><th>Présent dans</th><td><?= $nbCollections ?> collection(s)</td></tr>
</table>

<p class="actions">
    <a href="<?= e(url('index.php', ['action' => 'modifierJeu', 'id' => $jeu->getIdJeu()])) ?>" class="btn btn-secondary btn-sm">Modifier</a>
    <?php
        $supprAction = 'supprimerJeu';
        $supprParams = ['id' => $jeu->getIdJeu()];
        $supprLibelle = 'Supprimer du catalogue';
        $supprConfirmation = "Supprimer « {$jeu->getTitre()} » ? Il sera aussi retiré de " . $nbCollections . " collection(s).";
        include __DIR__ . "/../partials/bouton_supprimer.php";
    ?>
</p>

<p><a href="<?= e(url('index.php', ['action' => 'listeJeux'])) ?>" class="btn btn-back">← Catalogue</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>
