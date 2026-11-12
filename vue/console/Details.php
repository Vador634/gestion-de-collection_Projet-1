<?php /** @var int $nbJeux nombre de jeux associés */ ?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<table class="fiche">
    <tr><th>Nom</th><td><?= e($console->getNomConsole()) ?></td></tr>
    <tr><th>Fabricant</th><td><?= e($console->getFabricant()) ?></td></tr>
    <tr><th>Jeux associés</th><td><?= (int)$nbJeux ?></td></tr>
</table>

<p class="actions">
    <a href="<?= e(url('index.php', ['action' => 'modifierConsole', 'id' => $console->getIdConsole()])) ?>" class="btn btn-secondary btn-sm">Modifier</a>
    <?php
        $supprAction = 'supprimerConsole';
        $supprParams = ['id' => $console->getIdConsole()];
        $supprLibelle = 'Supprimer';
        $supprConfirmation = "Supprimer la console « " . $console->getNomConsole() . " » ?" . ($nbJeux ? " $nbJeux jeu(x) l'utilisent : le lien sera supprimé." : "");
        include __DIR__ . "/../partials/bouton_supprimer.php";
    ?>
</p>

<p><a href="<?= e(url('index.php', ['action' => 'listerConsoles'])) ?>" class="btn btn-back">← Retour à la liste</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>
