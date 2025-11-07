<?php
session_start();

// ✅ Routeur : gestion des actions
if (isset($_GET['action'])) {
    require_once __DIR__ . '/controleur/UtilisateurController.php';
    $controller = new UtilisateurController();
    
    switch ($_GET['action']) {
        case 'login':
            $controller->login();
            exit;
            
        case 'register':
            $controller->register();
            exit;
            
        case 'logout':
            $controller->logout();
            exit;
            
        case 'profil':
            $controller->profil();
            exit;
            
        default:
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
</head>
<body>
    <h1>Accueil - Gestion de Collection</h1>
    <?php if (!isset($_SESSION['utilisateur'])): ?>
        <a href="Index.php?action=login">Connexion</a> |
        <a href="Index.php?action=register">Inscription</a>
    <?php else: ?>
        <p>Bienvenue <strong><?php echo htmlspecialchars($_SESSION['utilisateur']['pseudo']); ?></strong></p>
        <a href="vue/collection/VueCollection.php">Voir mes collections</a> |
        <a href="Index.php?action=logout">Déconnexion</a> |
        <a href="Index.php?action=profil">Mon profil</a>
    <?php endif; ?>
</body>
</html>






