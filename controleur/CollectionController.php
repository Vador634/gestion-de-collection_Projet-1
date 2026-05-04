<?php
class CollectionController {

    /**
     * Affiche la liste de toutes les collections.
     * @return void
     */
    public function liste() {
        $collections = CollectionDAO::getAll();
        $counts = [];
        // Préparation des données pour la vue afin de respecter le pattern MVC
        foreach ($collections as $col) {
            $counts[$col->idCollection] = CollectionDAO::countJeux($col->idCollection);
        }
        include __DIR__ . "/../vue/collection/liste.php";
    }


    /**
     * Affiche les détails d'une collection spécifique.
     * 
     * @param int $id Identifiant de la collection
     * @return void
     */
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


    /**
     * Gère la création d'une nouvelle collection.
     * @return void
     */
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


    /**
     * Gère la modification d'une collection existante.
     * 
     * @param int $id Identifiant de la collection
     * @return void
     */
    public function modifier($id) {

        $collection = CollectionDAO::getById($id);

        if (!$collection) {
            echo "Collection introuvable.";
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nom = trim($_POST['nomCollection'] ?? '');
            $note = trim($_POST['notePerso'] ?? '') ?: null;

            if ($nom === '') {
                $erreur = "Le nom de la collection est obligatoire.";
                include __DIR__ . "/../vue/collection/Modifier.php";
                return;
            }

            CollectionDAO::update($id, $nom, $note);

            header("Location: " . url('Index.php', ['action' => 'detailsCollection', 'id' => $id]));
            exit;
        }

        include __DIR__ . "/../vue/collection/Modifier.php";
    }


    /**
     * Supprime une collection existante.
     * 
     * @param int $id Identifiant de la collection
     * @return void
     */
    public function supprimer($id) {
        CollectionDAO::delete($id);
        header("Location: " . url('Index.php', ['action' => 'listeCollections']));
        exit;
    }


    /**
     * Associe un jeu à une collection.
     * 
     * @param int $idCollection Identifiant de la collection
     * @return void
     */
    public function ajouterJeuCollection($idCollection) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idJeu = filter_input(INPUT_POST, 'idJeu', FILTER_VALIDATE_INT);
            if ($idJeu) {
                CollectionDAO::ajouterJeu($idCollection, $idJeu);
            }
        }
        header("Location: " . url('Index.php', ['action' => 'detailsCollection', 'id' => $idCollection]));
        exit;
    }

    /**
     * Retire un jeu d'une collection.
     * 
     * @param int $idCollection Identifiant de la collection
     * @param int $idJeu Identifiant du jeu
     * @return void
     */
    public function retirerJeuCollection($idCollection, $idJeu) {
        CollectionDAO::retirerJeu($idCollection, $idJeu);
        header("Location: " . url('Index.php', ['action' => 'detailsCollection', 'id' => $idCollection]));
        exit;
    }
}
