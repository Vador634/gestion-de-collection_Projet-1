<?php
/**
 * Point d'entrée unique de l'application (routeur).
 *
 * Chaque action de l'URL (?action=...) est associée à un contrôleur, une
 * méthode et ses règles d'accès :
 *   - public : accessible sans être connecté
 *   - post   : action qui modifie la base, acceptée uniquement en POST
 *   - params : paramètres entiers attendus dans l'URL (id, idJeu)
 * Tout formulaire POST doit contenir le jeton CSRF de la session.
 */
session_start();
require_once __DIR__ . '/config/autoload.php';

$routes = [
    // Utilisateur
    'login'                => ['UtilisateurController', 'login',  'public' => true],
    'register'             => ['UtilisateurController', 'register', 'public' => true],
    'logout'               => ['UtilisateurController', 'logout', 'public' => true],
    'profil'               => ['UtilisateurController', 'profil'],
    'documentation'        => ['DocumentController', 'show', 'public' => true],

    // Collections (chaque utilisateur ne voit et ne modifie que les siennes)
    'listeCollections'     => ['CollectionController', 'liste'],
    'detailsCollection'    => ['CollectionController', 'details', 'params' => ['id']],
    'creerCollection'      => ['CollectionController', 'creer'],
    'modifierCollection'   => ['CollectionController', 'modifier', 'params' => ['id']],
    'supprimerCollection'  => ['CollectionController', 'supprimer', 'params' => ['id'], 'post' => true],
    'ajouterJeuCollection' => ['CollectionController', 'ajouterJeuCollection', 'params' => ['id'], 'post' => true],
    'retirerJeuCollection' => ['CollectionController', 'retirerJeuCollection', 'params' => ['id', 'idJeu'], 'post' => true],

    // Catalogue de jeux
    'listeJeux'            => ['JeuController', 'liste'],
    'detailsJeu'           => ['JeuController', 'details', 'params' => ['id']],
    'ajouterJeu'           => ['JeuController', 'ajouter'],
    'modifierJeu'          => ['JeuController', 'modifier', 'params' => ['id']],
    'supprimerJeu'         => ['JeuController', 'supprimer', 'params' => ['id'], 'post' => true],

    // Référentiels : genres, éditeurs, consoles
    'listerGenres'         => ['GenreController', 'lister'],
    'detailsGenre'         => ['GenreController', 'details', 'params' => ['id']],
    'ajouterGenre'         => ['GenreController', 'ajouter'],
    'modifierGenre'        => ['GenreController', 'modifier', 'params' => ['id']],
    'supprimerGenre'       => ['GenreController', 'supprimer', 'params' => ['id'], 'post' => true],

    'listerEditeurs'       => ['EditeurController', 'lister'],
    'detailsEditeur'       => ['EditeurController', 'details', 'params' => ['id']],
    'ajouterEditeur'       => ['EditeurController', 'ajouter'],
    'modifierEditeur'      => ['EditeurController', 'modifier', 'params' => ['id']],
    'supprimerEditeur'     => ['EditeurController', 'supprimer', 'params' => ['id'], 'post' => true],

    'listerConsoles'       => ['ConsoleController', 'lister'],
    'detailsConsole'       => ['ConsoleController', 'details', 'params' => ['id']],
    'ajouterConsole'       => ['ConsoleController', 'ajouter'],
    'modifierConsole'      => ['ConsoleController', 'modifier', 'params' => ['id']],
    'supprimerConsole'     => ['ConsoleController', 'supprimer', 'params' => ['id'], 'post' => true],
];

$action = isset($_GET['action']) && is_string($_GET['action']) ? $_GET['action'] : '';

// Un formulaire sans jeton valide (expiré ou venant d'un autre site) est refusé
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !csrf_valide()) {
    flash("Le formulaire a expiré, merci de le renvoyer.");
    $retour = [];
    if (isset($routes[$action]) && empty($routes[$action]['post'])) {
        $retour = ['action' => $action];
        if (isset($_GET['id']) && ctype_digit((string)$_GET['id'])) $retour['id'] = $_GET['id'];
    }
    rediriger($retour);
}

if (!isset($routes[$action])) {
    // Action par défaut : accueil
    (new HomeController())->index();
    exit;
}

$route = $routes[$action];

if (empty($route['public']) && !utilisateur_id()) {
    flash("Connectez-vous pour accéder à cette page.");
    rediriger(['action' => 'login']);
}

if (!empty($route['post']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    page_erreur(405, "Cette action doit être confirmée depuis un bouton de l'application.");
}

// Paramètres d'URL : entiers strictement positifs
$arguments = [];
foreach ($route['params'] ?? [] as $nom) {
    $valeur = filter_input(INPUT_GET, $nom, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if (!$valeur) {
        page_erreur(404, "Élément introuvable.");
    }
    $arguments[] = $valeur;
}

$controleur = new $route[0]();
call_user_func_array([$controleur, $route[1]], $arguments);
