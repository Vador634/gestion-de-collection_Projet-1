<?php
class JeuController {
    public function liste() {
        $jeux = JeuDAO::getAll();
        include __DIR__ . "/../vue/jeu/Liste.php";
    }

    public function details($id) {
        $jeu = JeuDAO::getById($id);
        if (!$jeu) {
            header("HTTP/1.0 404 Not Found");
            echo "Jeu introuvable.";
            exit;
        }
        // récupérer associations pour affichage
        $consoles = JeuDAO::getConsoles($id);
        $genres = JeuDAO::getGenres($id);
        $editeurs = JeuDAO::getEditeurs($id);
        include __DIR__ . "/../vue/jeu/Details.php";
    }

    public function ajouter() {
        // on peut arriver depuis une collection
        $idCollection = $_GET['idCollection'] ?? null;

        // récupérations de listes de référence pour les selects
        $conditions = ConditionDAO::getAll();
        $raretes = RareteDAO::getAll();
        $developpeurs = DeveloppeurDAO::getAll();
        $consoles = ConsoleDAO::getAll();
        $genres = GenreDAO::getAll();
        $editeurs = EditeurDAO::getAll();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $titre = $_POST["titre"] ?? '';
            $annee = $_POST["anneeSortie"] ?? null;
            $prix = $_POST["prixEstime"] ?? null;
            $cond = $_POST['idCondition'] ?? null;
            $rare = $_POST['idRarete'] ?? null;
            $dev  = $_POST['idDeveloppeur'] ?? null;
            $idCollection = $_POST['idCollection'] ?? $idCollection;
            $selConsoles = $_POST['consoles'] ?? [];
            $selGenres = $_POST['genres'] ?? [];
            $selEditeurs = $_POST['editeurs'] ?? [];

            if ($titre === '') {
                $erreur = "Le titre est obligatoire.";
                include __DIR__ . "/../vue/jeu/Ajouter.php";
                return;
            }

            $newId = JeuDAO::insert($titre, $annee, $prix, $cond, $rare, $dev);
            if ($newId) {
                JeuDAO::setConsoles($newId, $selConsoles);
                JeuDAO::setGenres($newId, $selGenres);
                JeuDAO::setEditeurs($newId, $selEditeurs);
            }
            if ($newId && $idCollection) {
                CollectionDAO::ajouterJeu($idCollection, $newId);
                header("Location: " . url('Index.php', ['action' => 'detailsCollection', 'id' => $idCollection]));
            } else {
                header("Location: " . url('Index.php', ['action' => 'listeJeux']));
            }
            exit;
        }
        include __DIR__ . "/../vue/jeu/Ajouter.php";
    }

    public function modifier($id) {
        $jeu = JeuDAO::getById($id);
        if (!$jeu) {
            echo "Jeu introuvable.";
            exit;
        }

        // listes à afficher
        $conditions = ConditionDAO::getAll();
        $raretes = RareteDAO::getAll();
        $developpeurs = DeveloppeurDAO::getAll();
        $consoles = ConsoleDAO::getAll();
        $genres = GenreDAO::getAll();
        $editeurs = EditeurDAO::getAll();

        // sélectionner les valeurs actuelles
        $currentConsoles = JeuDAO::getConsoles($id);
        $currentGenres = JeuDAO::getGenres($id);
        $currentEditeurs = JeuDAO::getEditeurs($id);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $titre = $_POST["titre"] ?? '';
            $annee = $_POST["anneeSortie"] ?? null;
            $prix = $_POST["prixEstime"] ?? null;
            $cond = $_POST['idCondition'] ?? null;
            $rare = $_POST['idRarete'] ?? null;
            $dev  = $_POST['idDeveloppeur'] ?? null;
            $selConsoles = $_POST['consoles'] ?? [];
            $selGenres = $_POST['genres'] ?? [];
            $selEditeurs = $_POST['editeurs'] ?? [];
            
            JeuDAO::update($id, $titre, $annee, $prix, $cond, $rare, $dev);
            JeuDAO::setConsoles($id, $selConsoles);
            JeuDAO::setGenres($id, $selGenres);
            JeuDAO::setEditeurs($id, $selEditeurs);
            header("Location: " . url('Index.php', ['action' => 'detailsJeu', 'id' => $id]));
            exit;
        }
        include __DIR__ . "/../vue/jeu/Modifier.php";
    }

    public function supprimer($id) {
        JeuDAO::delete($id);
        header("Location: " . url('Index.php', ['action' => 'listeJeux']));
        exit;
    }
}


