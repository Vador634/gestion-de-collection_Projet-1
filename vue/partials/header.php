<?php
$titrePage = $pageTitle ?? "Gestion de Collection";
$actionCourante = isset($_GET['action']) && is_string($_GET['action']) ? $_GET['action'] : '';
// Rubrique d'une action : listeJeux, detailsJeu, modifierJeu... => "Jeu"
$rubrique = function ($action) {
    foreach (['Collection', 'Jeu', 'Console', 'Genre', 'Editeur', 'profil', 'documentation', 'login', 'register'] as $mot) {
        if (stripos($action, $mot) !== false) return $mot;
    }
    return '';
};
$menu = function ($action, $libelle) use ($actionCourante, $rubrique) {
    $actif = $actionCourante !== '' && $rubrique($actionCourante) === $rubrique($action);
    return '<a href="' . e(url('index.php', ['action' => $action])) . '"' . ($actif ? ' class="active"' : '') . '>' . e($libelle) . '</a>';
};
$message = flash();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titrePage) ?> — Gestion de Collection</title>
    <link rel="stylesheet" href="<?= e(url('assets/style.css')) ?>">
</head>
<body>
    <header>
        <h1><?= e($titrePage) ?></h1>
        <nav>
            <a href="<?= e(url('index.php')) ?>">Accueil</a>
            <?php if (utilisateur_id()): ?>
                <?= $menu('listeCollections', 'Mes collections') ?>
                <?= $menu('listeJeux', 'Jeux') ?>
                <?= $menu('listerConsoles', 'Consoles') ?>
                <?= $menu('listerGenres', 'Genres') ?>
                <?= $menu('listerEditeurs', 'Éditeurs') ?>
                <?= $menu('documentation', 'Documentation') ?>
                <?= $menu('profil', 'Profil') ?>
                <a href="<?= e(url('index.php', ['action' => 'logout'])) ?>">Déconnexion</a>
            <?php else: ?>
                <?= $menu('login', 'Connexion') ?>
                <?= $menu('register', 'Inscription') ?>
                <?= $menu('documentation', 'Documentation') ?>
            <?php endif; ?>
        </nav>
    </header>
    <main>
    <?php if ($message): ?>
        <p class="alert alert-success" role="status"><?= e($message) ?></p>
    <?php endif; ?>
