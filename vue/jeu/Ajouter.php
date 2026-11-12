<?php
/** @var int|null $idCollection collection dans laquelle ajouter le jeu directement */
$actionFormulaire = url('index.php', ['action' => 'ajouterJeu']);
$libelleBouton = $idCollection ? "Ajouter le jeu à la collection" : "Ajouter au catalogue";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<?php include __DIR__ . "/_formulaire.php"; ?>

<p>
    <?php if ($idCollection): ?>
        <a href="<?= e(url('index.php', ['action' => 'detailsCollection', 'id' => $idCollection])) ?>" class="btn btn-back">← Retour à la collection</a>
    <?php else: ?>
        <a href="<?= e(url('index.php', ['action' => 'listeJeux'])) ?>" class="btn btn-back">← Retour au catalogue</a>
    <?php endif; ?>
</p>

<?php include __DIR__ . "/../partials/footer.php"; ?>
