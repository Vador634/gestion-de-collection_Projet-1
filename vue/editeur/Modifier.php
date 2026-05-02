<?php
$pageTitle = "Modifier un éditeur";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Modifier un éditeur</h2>
<?php if (!empty($erreur)): ?>
    <p style="color:red"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<?php if ($editeur): ?>
<form method="post" action="<?= url('Index.php',['action'=>'modifierEditeur','id'=>$editeur->idEditeur]) ?>">
    <label>Nom éditeur :</label><br>
    <input type="text" name="libelleEditeur" value="<?= htmlspecialchars($editeur->libelleEditeur) ?>" required><br><br>
    <button type="submit">Modifier</button>
</form>
<?php else: ?>
    <p>Éditeur introuvable.</p>
<?php endif; ?>

<a href="<?= url('Index.php',['action'=>'listerEditeurs']) ?>">Retour à la liste</a>

<?php include __DIR__ . "/../partials/footer.php"; ?>