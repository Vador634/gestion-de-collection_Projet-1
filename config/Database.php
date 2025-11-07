<?php
function connexionPDO() {
    $login = "carascok";   
    $mdp = "08092006";     
    $bd = "GestionDeCollection";     
    $serveur = "192.168.20.15";

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