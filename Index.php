<?php
session_start();
require_once __DIR__ . '/config/autoload.php';

// ✅ Routeur : gestion des actions
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    // Actions Utilisateur
    if (in_array($action, ['login', 'register', 'logout', 'profil'])) {
        require_once __DIR__ . '/controleur/UtilisateurController.php';
        $controller = new UtilisateurController();
        
        switch ($action) {
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
        }
    }
    
    // Actions Collection
    if (in_array($action, [
        'listeCollections',
        'detailsCollection',
        'creerCollection',
        'modifierCollection',
        'supprimerCollection',
        'ajouterJeuCollection',      // nouvelle action pour associer un jeu
        'retirerJeuCollection'       // retirer un jeu de la collection
    ])) {
        require_once __DIR__ . '/controleur/CollectionController.php';
        $controller = new CollectionController();
        
        switch ($action) {
            case 'listeCollections':
                $controller->liste();
                exit;
            case 'detailsCollection':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->details($id);
                exit;
            case 'creerCollection':
                $controller->creer();
                exit;
            case 'modifierCollection':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->modifier($id);
                exit;
            case 'supprimerCollection':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->supprimer($id);
                exit;
            case 'ajouterJeuCollection':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->ajouterJeuCollection($id);
                exit;
            case 'retirerJeuCollection':
                $id = $_GET['id'] ?? null;
                $idJeu = $_GET['idJeu'] ?? null;
                if ($id && $idJeu) $controller->retirerJeuCollection($id, $idJeu);
                exit;
        }
    }
    
    // Actions Jeu
    if (in_array($action, ['listeJeux', 'detailsJeu', 'ajouterJeu', 'modifierJeu', 'supprimerJeu'])) {
        require_once __DIR__ . '/controleur/JeuController.php';
        $controller = new JeuController();
        
        switch ($action) {
            case 'listeJeux':
                $controller->liste();
                exit;
            case 'detailsJeu':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->details($id);
                exit;
            case 'ajouterJeu':
                $controller->ajouter();
                exit;
            case 'modifierJeu':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->modifier($id);
                exit;
            case 'supprimerJeu':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->supprimer($id);
                exit;
        }
    }
    
    // Actions Genre
    if (in_array($action, ['listerGenres', 'detailsGenre', 'ajouterGenre', 'modifierGenre', 'supprimerGenre'])) {
        require_once __DIR__ . '/controleur/GenreController.php';
        $controller = new GenreController();
        
        switch ($action) {
            case 'listerGenres':
                $controller->lister();
                exit;
            case 'detailsGenre':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->details($id);
                exit;
            case 'ajouterGenre':
                $controller->ajouter();
                exit;
            case 'modifierGenre':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->modifier($id);
                exit;
            case 'supprimerGenre':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->supprimer($id);
                exit;
        }
    }
    // Actions Editeur (pour associer aux jeux)
    if (in_array($action, ['listerEditeurs','detailsEditeur','ajouterEditeur','modifierEditeur','supprimerEditeur'])) {
        require_once __DIR__ . '/controleur/EditeurController.php';
        $controller = new EditeurController();
        switch ($action) {
            case 'listerEditeurs':
                $controller->lister();
                exit;
            case 'detailsEditeur':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->details($id);
                exit;
            case 'ajouterEditeur':
                $controller->ajouter();
                exit;
            case 'modifierEditeur':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->modifier($id);
                exit;
            case 'supprimerEditeur':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->supprimer($id);
                exit;
        }
    }
    
    // Actions Console
    if (in_array($action, ['listerConsoles', 'detailsConsole', 'ajouterConsole', 'modifierConsole', 'supprimerConsole'])) {
        require_once __DIR__ . '/controleur/ConsoleController.php';
        $controller = new ConsoleController();
        
        switch ($action) {
            case 'listerConsoles':
                $controller->lister();
                exit;
            case 'detailsConsole':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->details($id);
                exit;
            case 'ajouterConsole':
                $controller->ajouter();
                exit;
            case 'modifierConsole':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->modifier($id);
                exit;
            case 'supprimerConsole':
                $id = $_GET['id'] ?? null;
                if ($id) $controller->supprimer($id);
                exit;
        }
    }
    // Documentation générale du site
    if ($action === 'documentation') {
        require_once __DIR__ . '/controleur/DocumentController.php';
        $controller = new DocumentController();
        $controller->show();
        exit;
    }
    }
?>
<?php
// page d'accueil
$pageTitle = "Accueil";
include __DIR__ . '/vue/partials/Header.php';
?>

<?php if (!isset($_SESSION['utilisateur'])): ?>
    <p><a class="btn" href="<?= url('Index.php', ['action' => 'login']) ?>">Connexion</a>
    <a class="btn" href="<?= url('Index.php', ['action' => 'register']) ?>">Inscription</a></p>
<?php else: ?>
    <p>Bienvenue <strong><?php echo htmlspecialchars($_SESSION['utilisateur']['pseudo']); ?></strong></p>
    <p>
        <a class="btn" href="<?= url('Index.php', ['action' => 'listeCollections']) ?>">Voir mes collections</a>
        <a class="btn" href="<?= url('Index.php', ['action' => 'profil']) ?>">Mon profil</a>
        <a class="btn" href="<?= url('Index.php', ['action' => 'documentation']) ?>">Documentation</a>
        <a class="btn" href="<?= url('Index.php', ['action' => 'logout']) ?>">Déconnexion</a>
    </p>
<?php endif; ?>

<?php include __DIR__ . '/vue/partials/Footer.php'; ?>






