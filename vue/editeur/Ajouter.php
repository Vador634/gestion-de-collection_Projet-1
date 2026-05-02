<?php
$pageTitle = "Ajouter un éditeur";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Ajouter un éditeur</h2>
<form method="post" action="<?= url('Index.php',['action'=>'ajouterEditeur']) ?>">
    <label>Nom éditeur :</label><br>
    <input type="text" name="libelleEditeur" required><br><br>
    <button type="submit">Ajouter</button>
</form>

<a href="<?= url('Index.php',['action'=>'listerEditeurs']) ?>">Retour à la liste</a>

<?php include __DIR__ . "/../partials/footer.php"; ?>