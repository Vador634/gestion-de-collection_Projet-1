<?php
require_once "controleur/JeuController.php";

$action = $_GET["action"] ?? "listeJeux";

switch ($action) {
    case "listeJeux":
        (new JeuController())->liste();
        break;

    case "detailsJeu":
        (new JeuController())->details($_GET["id"]);
        break;

    case "ajouterJeu":
        (new JeuController())->ajouter();
        break;

    default:
        echo "Page introuvable.";
}

