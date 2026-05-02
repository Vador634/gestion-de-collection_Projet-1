<?php
$pageTitle = "Détails éditeur";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Détails de l'éditeur</h2>
<?php if ($editeur): ?>
    <p><strong>Id :</strong> <?= htmlspecialchars($editeur->idEditeur) ?></p>
    <p><strong>Nom :</strong> <?= htmlspecialchars($editeur->libelleEditeur) ?></p>
    <p><a href="<?= url('Index.php',['action'=>'modifierEditeur','id'=>$editeur->idEditeur]) ?>">Modifier</a></p>
    <p><a href="<?= url('Index.php',['action'=>'listerEditeurs']) ?>">Retour à la liste</a></p>
<?php else: ?>
    <p>Éditeur introuvable.</p>
<?php endif; ?>

<?php include __DIR__ . "/../partials/footer.php"; ?>