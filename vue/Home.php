<?php include __DIR__ . '/partials/header.php'; ?>

<?php if (!isset($_SESSION['utilisateur'])): ?>
    <p>
        <a class="btn btn-primary" href="<?= url('Index.php', ['action' => 'login']) ?>">Connexion</a>
        <a class="btn btn-secondary" href="<?= url('Index.php', ['action' => 'register']) ?>">Inscription</a>
    </p>
<?php else: ?>
    <p>Bienvenue <strong><?= htmlspecialchars($_SESSION['utilisateur']['pseudo']) ?></strong></p>
    <p>
        <a class="btn btn-primary" href="<?= url('Index.php', ['action' => 'listeCollections']) ?>">Voir mes collections</a>
        <a class="btn btn-secondary" href="<?= url('Index.php', ['action' => 'profil']) ?>">Mon profil</a>
        <a class="btn btn-secondary" href="<?= url('Index.php', ['action' => 'documentation']) ?>">Documentation</a>
        <a class="btn btn-danger" href="<?= url('Index.php', ['action' => 'logout']) ?>">Déconnexion</a>
    </p>
<?php endif; ?>

<?php include __DIR__ . '/partials/footer.php'; ?>