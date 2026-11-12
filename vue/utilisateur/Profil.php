<?php
/** @var Utilisateur $utilisateur */
/** @var int $nbCollections */
$pageTitle = "Mon profil";
?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<table class="fiche">
    <tr><th>Pseudo</th><td><?= e($utilisateur->getPseudo()) ?></td></tr>
    <tr><th>Nom</th><td><?= e($utilisateur->getNom()) ?></td></tr>
    <tr><th>Prénom</th><td><?= e($utilisateur->getPrenom()) ?></td></tr>
    <tr><th>Email</th><td><?= e($utilisateur->getEmail()) ?></td></tr>
    <tr><th>Collections</th><td><?= (int)$nbCollections ?></td></tr>
</table>

<p class="actions">
    <a href="<?= e(url('index.php', ['action' => 'listeCollections'])) ?>" class="btn btn-primary">Mes collections</a>
    <a href="<?= e(url('index.php', ['action' => 'logout'])) ?>" class="btn btn-secondary">Déconnexion</a>
</p>

<?php include __DIR__ . '/../partials/footer.php'; ?>
