<?php
class CollectionController {

    /* ================================
       AFFICHER TOUTES LES COLLECTIONS
       ================================ */
    public function liste() {
        $collections = CollectionDAO::getAll();
        include __DIR__ . "/../vue/collection/liste.php";
    }


    /* ================================
       DETAILS D'UNE COLLECTION
       ================================ */
    public function details($id) {
        $collection = CollectionDAO::getById($id);

        if (!$collection) {
            header("HTTP/1.0 404 Not Found");
            echo "Collection introuvable.";
            exit;
        }

        // récupération des jeux liés et calcul du nombre à partir du tableau
        $jeux = CollectionDAO::getJeuxInCollection($id);
        $nbJeux = count($jeux);

        // on prépare également la liste complète des jeux pour proposer un ajout
        // (utile à la vue, sinon on pourrait la charger via Ajax ou autre)
        $allJeux = JeuDAO::getAll();

        include __DIR__ . "/../vue/collection/Details.php";
    }


    /* ================================
       CRÉATION D'UNE COLLECTION
       ================================ */
    public function creer() {
        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['utilisateur']['id'])) {
            $erreur = "Vous devez être connecté.";
            include __DIR__ . "/../vue/collection/Creer.php";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nom = trim($_POST['nomCollection'] ?? '');
            $note = trim($_POST['notePerso'] ?? '') ?: null;

            $idUtilisateur = $_SESSION['utilisateur']['id']; // L'ID utilisateur en session

            if ($nom === '') {
                $erreur = "Le nom de la collection est obligatoire.";
                include __DIR__ . "/../vue/collection/Creer.php";
                return;
            }

            // Insertion dans la BDD
            $idNouvelleCollection = CollectionDAO::insert($nom, $idUtilisateur, $note);

            // Redirection correcte
            header("Location: " . url('Index.php', ['action' => 'listeCollections']));
            exit;
        }

        include __DIR__ . "/../vue/collection/Creer.php";
    }


    /* ================================
       MODIFIER UNE COLLECTION
       ================================ */
    public function modifier($id) {

        $collection = CollectionDAO::getById($id);

        if (!$collection) {
            echo "Collection introuvable.";
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nom = trim($_POST['nomCollection'] ?? '');
            $note = trim($_POST['notePerso'] ?? '') ?: null;

            CollectionDAO::update($id, $nom, $note);

            header("Location: " . url('Index.php', ['action' => 'detailsCollection', 'id' => $id]));
            exit;
        }

        include __DIR__ . "/../vue/collection/Modifier.php";
    }


    /* ================================
       SUPPRIMER UNE COLLECTION
       ================================ */
    public function supprimer($id) {
        CollectionDAO::delete($id);
        header("Location: " . url('Index.php', ['action' => 'listeCollections']));
        exit;
    }


    /* ================================
       AJOUTER / RETIRER UN JEU
       ================================ */
    // méthodes à usage interne (utilisées par les nouvelles routes)
    public function ajouterJeuCollection($idCollection) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idJeu = $_POST['idJeu'] ?? null;
            if ($idJeu) {
                CollectionDAO::ajouterJeu($idCollection, $idJeu);
            }
        }
        header("Location: " . url('Index.php', ['action' => 'detailsCollection', 'id' => $idCollection]));
        exit;
    }

    public function retirerJeuCollection($idCollection, $idJeu) {
        CollectionDAO::retirerJeu($idCollection, $idJeu);
        header("Location: " . url('Index.php', ['action' => 'detailsCollection', 'id' => $idCollection]));
        exit;
    }
}

