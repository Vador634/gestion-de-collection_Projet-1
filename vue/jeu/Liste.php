<?php
/** @var Jeu[] $jeux */
/** @var array $consolesParJeu */

$pageTitle = "Liste des jeux";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Liste des Jeux</h2>
<ul>
<?php foreach ($jeux as $jeu): ?>
     <li>
         <?= htmlspecialchars($jeu->getTitre()) ?> (<?= htmlspecialchars($jeu->getAnneeSortie()) ?>) - <?= htmlspecialchars($jeu->getPrixEstime()) ?>€
         <?php
             // Données déjà préparées par le contrôleur (plus de DAO ici !)
             $consoles = $consolesParJeu[$jeu->getIdJeu()] ?? [];
         ?>
         <?php if (!empty($consoles)): ?>
             <br><small>Consoles: 
             <?php
                 $names = [];
                 foreach ($consoles as $c):
                     /** @var Console $c */
                     $names[] = $c->getNomConsole();
                 endforeach;
                 echo htmlspecialchars(implode(', ', $names));
             ?>
             </small>
         <?php endif; ?>
         <br><a href="<?= url('Index.php', ['action' => 'detailsJeu', 'id' => $jeu->getIdJeu()]) ?>">Détails</a>
     </li>
<?php endforeach; ?>
</ul>

<div style="margin-top:20px;">
    <a href="<?= url('Index.php', ['action' => 'ajouterJeu']) ?>" class="btn btn-primary">Ajouter un jeu</a>
    <a href="<?= url('Index.php') ?>" class="btn btn-secondary">Retour à l'accueil</a>
</div>

<?php include __DIR__ . "/../partials/footer.php"; ?>
