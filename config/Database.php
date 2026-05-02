<?php
function connexionPDO() {
    $login = "root";   
    $mdp = "";     
    $bd = "gestion_de_collection";     
    $serveur = "127.0.0.1";

    try {
        $conn = new PDO(
            "mysql:host=$serveur;dbname=$bd;charset=utf8",
            $login,
            $mdp,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')
        ); 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Erreur de connexion PDO : " . $e->getMessage());
    }
}