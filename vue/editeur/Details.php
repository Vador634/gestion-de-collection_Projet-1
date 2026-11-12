<?php /** @var int $nbJeux nombre de jeux associés */ ?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<table class="fiche">
    <tr><th>Nom</th><td><?= e($editeur->libelleEditeur) ?></td></tr>
    
    <tr><th>Jeux associés</th><td><?= (int)$nbJeux ?></td></tr>
</table>

<p class="actions">
    <a href="<?= e(url('index.php', ['action' => 'modifierEditeur', 'id' => $editeur->idEditeur])) ?>" class="btn btn-secondary btn-sm">Modifier</a>
    <?php
        $supprAction = 'supprimerEditeur';
        $supprParams = ['id' => $editeur->idEditeur];
        $supprLibelle = 'Supprimer';
        $supprConfirmation = "Supprimer l'éditeur « " . $editeur->libelleEditeur . " » ?" . ($nbJeux ? " $nbJeux jeu(x) l'utilisent : le lien sera supprimé." : "");
        include __DIR__ . "/../partials/bouton_supprimer.php";
    ?>
</p>

<p><a href="<?= e(url('index.php', ['action' => 'listerEditeurs'])) ?>" class="btn btn-back">← Retour à la liste</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>
