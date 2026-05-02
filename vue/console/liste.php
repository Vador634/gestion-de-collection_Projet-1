<?php
$pageTitle = "Liste des consoles";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h1>Liste des Consoles</h1>

<ul>
    <?php foreach ($consoles as $c): ?>
         <li>
             <a href="<?= url('Index.php', ['action' => 'detailsConsole', 'id' => $c->getIdConsole()]) ?>">
                 <?php echo htmlspecialchars($c->getNomConsole()); ?>
             </a>
             (<?php echo htmlspecialchars($c->getFabricant()); ?>)
         </li>
     <?php endforeach; ?>
 </ul>

 <h2>Ajouter une console</h2>
 <form method="POST" action="<?= url('Index.php', ['action' => 'ajouterConsole']) ?>">
     Nom de la console : <input type="text" name="nomConsole" required><br>
     Fabricant : <input type="text" name="fabricant" required><br>
     <input type="submit" value="Ajouter">
 </form>

<div style="margin-top:20px;">
    <a href="<?= url('Index.php') ?>">Retour à l'accueil</a>
</div>

<?php include __DIR__ . "/../partials/footer.php"; ?>
