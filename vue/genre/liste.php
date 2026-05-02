<?php
$pageTitle = "Liste des genres";
?><?php include __DIR__ . "/../partials/header.php"; ?>

<h1>Liste des Genres</h1>

<ul>
    <?php foreach ($genres as $g): ?>
         <li>
             <a href="<?= url('Index.php', ['action' => 'detailsGenre', 'id' => $g->getIdGenre()]) ?>">
                 <?php echo htmlspecialchars($g->getNomGenre()); ?>
             </a>
         </li>
     <?php endforeach; ?>
 </ul>

 <h2>Ajouter un genre</h2>
 <form method="POST" action="<?= url('Index.php', ['action' => 'ajouterGenre']) ?>">
     Nom du genre : <input type="text" name="nomGenre" required><br>
     <input type="submit" value="Ajouter">
 </form>

<div style="margin-top:20px;">
    <a href="<?= url('Index.php') ?>">Retour à l'accueil</a>
</div>

<?php include __DIR__ . "/../partials/footer.php"; ?>
