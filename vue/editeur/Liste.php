<?php
$pageTitle = "Liste des éditeurs";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Liste des éditeurs</h2>
<ul>
<?php foreach ($editeurs as $e): ?>
    <li>
        <?= htmlspecialchars($e->libelleEditeur) ?> 
        (<a href="<?= url('Index.php',['action'=>'detailsEditeur','id'=>$e->idEditeur]) ?>">Détails</a>)
    </li>
<?php endforeach; ?>
</ul>

<a href="<?= url('Index.php',['action'=>'ajouterEditeur']) ?>">Ajouter un éditeur</a>
<a href="<?= url('Index.php') ?>">Retour</a>

<?php include __DIR__ . "/../partials/footer.php"; ?>