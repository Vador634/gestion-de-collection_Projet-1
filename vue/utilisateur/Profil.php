<?php
/** @var Utilisateur $utilisateur */

$pageTitle = "Profil";
?>
<?php include_once __DIR__ . '/../partials/header.php'; ?>

<h2>Profil de l'utilisateur</h2>

<p><strong>ID :</strong> <?= htmlspecialchars($utilisateur->getId()) ?></p>
<p><strong>Nom :</strong> <?= htmlspecialchars($utilisateur->getNom()) ?></p>
<p><strong>Prénom :</strong> <?= htmlspecialchars($utilisateur->getPrenom()) ?></p>
<p><strong>Pseudo :</strong> <?= htmlspecialchars($utilisateur->getPseudo()) ?></p>
<p><strong>Email :</strong> <?= htmlspecialchars($utilisateur->getEmail()) ?></p>

<!-- Boutons -->
<div style="margin-top:20px;">
    <a href="<?= url('Index.php') ?>" class="btn">Retour à l'accueil</a>
    <a href="<?= url('Index.php', ['action' => 'logout']) ?>" class="btn" style="margin-left:10px;">Déconnexion</a>
</div>

<?php include_once __DIR__ . '/../partials/footer.php'; ?>
