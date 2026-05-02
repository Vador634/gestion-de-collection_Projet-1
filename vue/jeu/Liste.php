<?php
$pageTitle = "Liste des jeux";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Liste des Jeux</h2>
<ul>
<?php foreach ($jeux as $jeu): ?>
     <li>
         <?= htmlspecialchars($jeu->getTitre()) ?> (<?= htmlspecialchars($jeu->getAnneeSortie()) ?>) - <?= htmlspecialchars($jeu->getPrixEstime()) ?>€
         <?php
             $consoles = JeuDAO::getConsoles($jeu->getIdJeu());
             if (!empty($consoles)) {
                 echo '<br><small>Consoles: ';
                 $names = [];
                 foreach ($consoles as $c) {
                     $names[] = htmlspecialchars($c->getNomConsole());
                 }
                 echo implode(', ', $names);
                 echo '</small>';
             }
         ?>
         <br><a href="<?= url('Index.php', ['action' => 'detailsJeu', 'id' => $jeu->getIdJeu()]) ?>">Détails</a>
     </li>
<?php endforeach; ?>
</ul>

<div style="margin-top:20px;">
    <a href="<?= url('Index.php', ['action' => 'ajouterJeu']) ?>">Ajouter un jeu</a> |
    <a href="<?= url('Index.php') ?>">Retour à l'accueil</a>
</div>

<?php include __DIR__ . "/../partials/footer.php"; ?>

