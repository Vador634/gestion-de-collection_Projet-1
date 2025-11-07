<?php
require_once __DIR__ . "/../modele/JeuDAO.php";

class JeuController {
    public function liste() {
        $jeux = JeuDAO::getAll();
        include __DIR__ . "/../vue/jeu/liste.php";
    }

    public function details($id) {
        $jeu = JeuDAO::getById($id);
        if (!$jeu) {
            header("HTTP/1.0 404 Not Found");
            echo "Jeu introuvable.";
            exit;
        }
        include __DIR__ . "/../vue/jeu/details.php";
    }

    public function ajouter() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $titre = $_POST["titre"] ?? '';
            $annee = $_POST["anneeSortie"] ?? null;
            $prix = $_POST["prixEstime"] ?? null;
            
            if ($titre === '') {
                $erreur = "Le titre est obligatoire.";
                include __DIR__ . "/../vue/jeu/ajouter.php";
                return;
            }
            
            JeuDAO::insert($titre, $annee, $prix);
            header("Location: Index.php?action=listeJeux");
            exit;
        }
        include __DIR__ . "/../vue/jeu/ajouter.php";
    }

    public function modifier($id) {
        $jeu = JeuDAO::getById($id);
        if (!$jeu) {
            echo "Jeu introuvable.";
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $titre = $_POST["titre"] ?? '';
            $annee = $_POST["anneeSortie"] ?? null;
            $prix = $_POST["prixEstime"] ?? null;
            
            JeuDAO::update($id, $titre, $annee, $prix);
            header("Location: Index.php?action=detailsJeu&id=" . $id);
            exit;
        }
        include __DIR__ . "/../vue/jeu/modifier.php";
    }

    public function supprimer($id) {
        JeuDAO::delete($id);
        header("Location: Index.php?action=listeJeux");
        exit;
    }
}


