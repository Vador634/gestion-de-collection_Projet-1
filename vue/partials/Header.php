<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? "Gestion de Collection" ?></title>
    <link rel="stylesheet" href="<?= url('assets/style.css') ?>">
</head>
<body>
    <header>
        <h1><?= $pageTitle ?? "Gestion de Collection" ?></h1>
        <nav>
             <a href="<?= url('Index.php') ?>">Accueil</a>
             <?php if(isset($_SESSION['utilisateur'])): ?>
                  | <a href="<?= url('Index.php', ['action' => 'profil']) ?>">Profil</a>
                  | <a href="<?= url('Index.php', ['action' => 'listeCollections']) ?>">Collections</a>
                  | <a href="<?= url('Index.php', ['action' => 'listerConsoles']) ?>">Consoles</a>
                  | <a href="<?= url('Index.php', ['action' => 'listerGenres']) ?>">Genres</a>
                  | <a href="<?= url('Index.php', ['action' => 'listerEditeurs']) ?>">Éditeurs</a>
                  | <a href="<?= url('Index.php', ['action' => 'documentation']) ?>">Documentation</a>
                  | <a href="<?= url('Index.php', ['action' => 'logout']) ?>">Déconnexion</a>
             <?php else: ?>
                  | <a href="<?= url('Index.php', ['action' => 'login']) ?>">Connexion</a>
                  | <a href="<?= url('Index.php', ['action' => 'register']) ?>">Inscription</a>
                  | <a href="<?= url('Index.php', ['action' => 'documentation']) ?>">Documentation</a>
             <?php endif; ?>
         </nav>
        <hr>
    </header>
    <main>
