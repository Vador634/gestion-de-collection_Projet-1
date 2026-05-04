<?php
// Autoload simple : mappe les classes aux dossiers `controleur/` et `modele/`
require_once __DIR__ . '/Database.php';

// Génération dynamique de la BASE_URL (s'adapte automatiquement à ton serveur Apache)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$dir = dirname($_SERVER['SCRIPT_NAME']);
$baseDir = rtrim(str_replace('\\', '/', $dir), '/');
define('BASE_URL', $protocol . $host . $baseDir . '/');

// Fonction helper pour les URLs
function url($path = '', $params = []) {
    $url = BASE_URL . ltrim($path, '/');
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    return $url;
}

spl_autoload_register(function ($class) {
    $base = __DIR__ . '/../';
    if (substr($class, -10) === 'Controller') {
        $file = $base . 'controleur/' . $class . '.php';
    } elseif (substr($class, -3) === 'DAO') {
        $file = $base . 'modele/' . $class . '.php';
    } else {
        $file = $base . 'modele/' . $class . '.php';
    }
    if (file_exists($file)) {
        require_once $file;
    }
});
