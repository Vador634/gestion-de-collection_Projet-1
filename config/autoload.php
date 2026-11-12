<?php
/**
 * Chargement automatique des classes et fonctions utilitaires communes.
 */
require_once __DIR__ . '/Database.php';

// URL de base calculée automatiquement (fonctionne dans un sous-dossier Apache)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$baseDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
define('BASE_URL', $protocol . $host . $baseDir . '/');

/** Construit une URL de l'application. */
function url($path = '', $params = []) {
    $url = BASE_URL . ltrim($path, '/');
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    return $url;
}

// Les contrôleurs sont dans controleur/, les modèles et DAO dans modele/
spl_autoload_register(function ($class) {
    $dossier = substr($class, -10) === 'Controller' ? 'controleur' : 'modele';
    $file = __DIR__ . "/../$dossier/$class.php";
    if (file_exists($file)) {
        require_once $file;
    }
});

/* ============================================================
   Fonctions utilitaires
   ============================================================ */

/** Échappe une valeur pour l'afficher dans du HTML. */
function e($valeur) {
    return htmlspecialchars((string)$valeur, ENT_QUOTES, 'UTF-8');
}

/** Jeton anti-CSRF propre à la session. */
function csrf_token() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

/** Champ caché à placer dans chaque formulaire POST. */
function csrf_field() {
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_valide() {
    return isset($_POST['csrf']) && is_string($_POST['csrf']) && hash_equals(csrf_token(), $_POST['csrf']);
}

/** Identifiant de l'utilisateur connecté, ou null. */
function utilisateur_id() {
    return isset($_SESSION['utilisateur']['id']) ? (int)$_SESSION['utilisateur']['id'] : null;
}

/** Message affiché une seule fois sur la page suivante. */
function flash($message = null) {
    if ($message !== null) {
        $_SESSION['flash'] = $message;
        return null;
    }
    $message = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $message;
}

/** Redirige vers une action puis arrête le script. */
function rediriger(array $params = []) {
    header('Location: ' . url('index.php', $params));
    exit;
}

/** Affiche une page d'erreur simple (404, 403...). */
function page_erreur($code, $message) {
    http_response_code($code);
    $pageTitle = $message;
    include __DIR__ . '/../vue/partials/header.php';
    echo '<p class="alert alert-error">' . e($message) . '</p>';
    echo '<p><a class="btn btn-secondary" href="' . e(url('index.php')) . '">Retour à l\'accueil</a></p>';
    include __DIR__ . '/../vue/partials/footer.php';
    exit;
}

/** Longueur d'une chaîne en caractères (mbstring si disponible). */
function longueur($texte) {
    return function_exists('mb_strlen') ? mb_strlen((string)$texte, 'UTF-8') : strlen((string)$texte);
}

/** Raccourcit un texte pour un aperçu (ex. dans un tableau). */
function extrait($texte, $max) {
    $texte = trim((string)$texte);
    if (longueur($texte) <= $max) return $texte;
    $debut = function_exists('mb_substr') ? mb_substr($texte, 0, $max - 1, 'UTF-8') : substr($texte, 0, $max - 1);
    return rtrim($debut) . '…';
}
