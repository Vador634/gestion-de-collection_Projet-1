<?php
require_once __DIR__ . "/../modele/CollectionDAO.php";

class CollectionController {

    public function liste() {
        $collections = CollectionDAO::getAll();
        include __DIR__ . "/../vue/collection/liste.php";
    }

    public function details($id) {
        $collection = CollectionDAO::getById($id);
        if (!$collection) {
            header("HTTP/1.0 404 Not Found");
            echo "Collection introuvable.";
            exit;
        }
        $nbJeux = CollectionDAO::countJeux($id);
        $jeux = CollectionDAO::getJeuxInCollection($id);
        include __DIR__ . "/../vue/collection/details.php";
    }

    public function creer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nomCollection'] ?? '';
            $etat = $_POST['etat'] ?? null;
            $note = $_POST['notePerso'] ?? null;
            
            // Récupérer l'utilisateur connecté depuis la session
            session_start();
            $idUtilisateur = $_SESSION['utilisateur']['id'] ?? 0;
            
            if ($nom === '' || $idUtilisateur <= 0) {
                $erreur = "Nom de collection requis et vous devez être connecté.";
                include __DIR__ . "/../vue/collection/creer.php";
                return;
            }
            
            $id = CollectionDAO::insert($nom, $idUtilisateur, $etat, $note);
            header("Location: Index.php?action=listeCollections");
            exit;
        }
        include __DIR__ . "/../vue/collection/creer.php";
    }

    public function modifier($id) {
        $collection = CollectionDAO::getById($id);
        if (!$collection) {
            echo "Collection introuvable.";
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nomCollection'] ?? '';
            $etat = $_POST['etat'] ?? null;
            $note = $_POST['notePerso'] ?? null;
            
            CollectionDAO::update($id, $nom, $etat, $note);
            header("Location: Index.php?action=detailsCollection&id=" . $id);
            exit;
        }
        include __DIR__ . "/../vue/collection/modifier.php";
    }

    public function supprimer($id) {
        CollectionDAO::delete($id);
        header("Location: Index.php?action=listeCollections");
        exit;
    }

    public function ajouterJeu($idCollection, $idJeu) {
        CollectionDAO::ajouterJeu($idCollection, $idJeu);
        header("Location: Index.php?action=detailsCollection&id=" . $idCollection);
        exit;
    }

    public function retirerJeu($idCollection, $idJeu) {
        CollectionDAO::retirerJeu($idCollection, $idJeu);
        header("Location: Index.php?action=detailsCollection&id=" . $idCollection);
        exit;
    }
}

