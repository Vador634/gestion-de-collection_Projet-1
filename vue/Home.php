<?php $pageTitle = "Gestion de Collection"; ?>
<?php include __DIR__ . '/partials/header.php'; ?>

<?php if (!utilisateur_id()): ?>
    <p class="lead">Répertoriez vos jeux vidéo, organisez-les en collections et suivez leur valeur estimée, leur état et leur rareté.</p>
    <p>
        <a class="btn btn-primary" href="<?= e(url('index.php', ['action' => 'login'])) ?>">Connexion</a>
        <a class="btn btn-secondary" href="<?= e(url('index.php', ['action' => 'register'])) ?>">Créer un compte</a>
    </p>
<?php else: ?>
    <p class="lead">Bienvenue <strong><?= e($_SESSION['utilisateur']['pseudo']) ?></strong> !</p>
    <p>
        <a class="btn btn-primary" href="<?= e(url('index.php', ['action' => 'listeCollections'])) ?>">Mes collections</a>
        <a class="btn btn-secondary" href="<?= e(url('index.php', ['action' => 'listeJeux'])) ?>">Catalogue de jeux</a>
        <a class="btn btn-secondary" href="<?= e(url('index.php', ['action' => 'ajouterJeu'])) ?>">Ajouter un jeu</a>
    </p>
<?php endif; ?>

<?php include __DIR__ . '/partials/footer.php'; ?>
