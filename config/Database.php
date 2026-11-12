<?php
/**
 * Connexion à la base de données.
 *
 * Une seule connexion PDO est ouverte par requête HTTP puis réutilisée par
 * tous les DAO. Les identifiants par défaut correspondent à une installation
 * locale (XAMPP / WAMP / Laragon) et peuvent être remplacés par des variables
 * d'environnement : GDC_DB_HOST, GDC_DB_NAME, GDC_DB_USER, GDC_DB_PASS
 * (ou GDC_DB_DSN pour un DSN PDO complet).
 */
function connexionPDO() {
    static $conn = null;
    if ($conn !== null) {
        return $conn;
    }

    $serveur = getenv('GDC_DB_HOST') ?: '127.0.0.1';
    $bd      = getenv('GDC_DB_NAME') ?: 'gestion_de_collection';
    $login   = getenv('GDC_DB_USER') ?: 'root';
    $mdp     = getenv('GDC_DB_PASS') ?: '';
    $dsn     = getenv('GDC_DB_DSN') ?: "mysql:host=$serveur;dbname=$bd;charset=utf8mb4";

    try {
        $conn = new PDO($dsn, $login, $mdp);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        http_response_code(500);
        die("Connexion à la base impossible. Vérifiez que la base « " . htmlspecialchars($bd)
            . " » est importée (GestionDeCollection.sql) et les identifiants dans config/Database.php.");
    }
}
