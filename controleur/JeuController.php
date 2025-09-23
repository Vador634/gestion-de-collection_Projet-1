<?php
require_once "modele/jeuDAO.php";

class JeuController {
    public function liste() {
        $jeux = JeuDAO::getAll();
        include "vue/jeu/liste.php";
    }

    public function details($id) {
        $jeu = JeuDAO::getById($id);
        include "vue/jeu/details.php";
    }

    public function ajouter() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $titre = $_POST["titre"];
            $annee = $_POST["anneeSortie"];
            $prix = $_POST["prixEstime"];
            JeuDAO::insert($titre, $annee, $prix);
            header("Location: index.php?action=listeJeux");
        }
        include "vue/jeu/ajouter.php";
    }
}

