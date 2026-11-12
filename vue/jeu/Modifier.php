<?php
/** @var Jeu $jeu */
$actionFormulaire = url('index.php', ['action' => 'modifierJeu', 'id' => $jeu->getIdJeu()]);
$libelleBouton = "Enregistrer";
$idCollection = null;
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<?php include __DIR__ . "/_formulaire.php"; ?>

<p><a href="<?= e(url('index.php', ['action' => 'detailsJeu', 'id' => $jeu->getIdJeu()])) ?>" class="btn btn-back">← Retour au jeu</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>
