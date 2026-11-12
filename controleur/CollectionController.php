<?php
/**
 * Collections de jeux : chaque utilisateur ne voit et ne modifie que les siennes.
 */
class CollectionController {

    /**
     * Charge une collection de l'utilisateur connecté, sinon page 404 / 403.
     * @return Collection
     */
    private function collectionDeLUtilisateur($id) {
        $collection = CollectionDAO::getById($id);
        if (!$collection) {
            page_erreur(404, "Collection introuvable.");
        }
        if ((int)$collection->idUtilisateur !== utilisateur_id()) {
            page_erreur(403, "Cette collection appartient à un autre utilisateur.");
        }
        return $collection;
    }

    /** Liste des collections de l'utilisateur connecté. */
    public function liste() {
        $collections = CollectionDAO::getByUser(utilisateur_id());
        $counts = CollectionDAO::countJeuxParCollection(array_map(function ($c) { return $c->idCollection; }, $collections));
        $pageTitle = "Mes collections";
        include __DIR__ . "/../vue/collection/Liste.php";
    }

    /** Détails d'une collection et jeux qu'elle contient. */
    public function details($id) {
        $collection = $this->collectionDeLUtilisateur($id);
        $jeux = CollectionDAO::getJeuxInCollection($id);
        $nbJeux = count($jeux);

        // Jeux du catalogue qui ne sont pas encore dans la collection
        $idsPresents = array_map(function ($j) { return $j->getIdJeu(); }, $jeux);
        $jeuxDisponibles = array_values(array_filter(JeuDAO::getAll(), function ($j) use ($idsPresents) {
            return !in_array($j->getIdJeu(), $idsPresents);
        }));

        $valeurTotale = 0;
        foreach ($jeux as $jeu) {
            $valeurTotale += (float)$jeu->getPrixEstime();
        }
        $pageTitle = $collection->nomCollection;
        include __DIR__ . "/../vue/collection/Details.php";
    }

    /** Création d'une collection. */
    public function creer() {
        $pageTitle = "Créer une collection";
        $nom = '';
        $note = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim((string)($_POST['nomCollection'] ?? ''));
            $note = trim((string)($_POST['notePerso'] ?? ''));

            $erreur = $this->valider($nom);
            if (!$erreur) {
                $id = CollectionDAO::insert($nom, utilisateur_id(), $note !== '' ? $note : null);
                flash("Collection « $nom » créée.");
                rediriger(['action' => 'detailsCollection', 'id' => $id]);
            }
        }
        include __DIR__ . "/../vue/collection/Creer.php";
    }

    /** Modification d'une collection. */
    public function modifier($id) {
        $collection = $this->collectionDeLUtilisateur($id);
        $pageTitle = "Modifier une collection";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim((string)($_POST['nomCollection'] ?? ''));
            $note = trim((string)($_POST['notePerso'] ?? ''));

            $erreur = $this->valider($nom);
            if (!$erreur) {
                CollectionDAO::update($id, $nom, $note !== '' ? $note : null);
                flash("Collection modifiée.");
                rediriger(['action' => 'detailsCollection', 'id' => $id]);
            }
            $collection->nomCollection = $nom;
            $collection->notePerso = $note;
        }
        include __DIR__ . "/../vue/collection/Modifier.php";
    }

    private function valider($nom) {
        if ($nom === '') return "Le nom de la collection est obligatoire.";
        if (longueur($nom) > 100) return "Le nom ne doit pas dépasser 100 caractères.";
        return null;
    }

    /** Suppression (POST uniquement, voir index.php). */
    public function supprimer($id) {
        $collection = $this->collectionDeLUtilisateur($id);
        CollectionDAO::delete($id);
        flash("Collection « {$collection->nomCollection} » supprimée.");
        rediriger(['action' => 'listeCollections']);
    }

    /** Ajoute un jeu existant à la collection. */
    public function ajouterJeuCollection($idCollection) {
        $this->collectionDeLUtilisateur($idCollection);
        $idJeu = filter_input(INPUT_POST, 'idJeu', FILTER_VALIDATE_INT);
        if ($idJeu && JeuDAO::getById($idJeu)) {
            flash(CollectionDAO::ajouterJeu($idCollection, $idJeu) ? "Jeu ajouté à la collection." : "Ce jeu est déjà dans la collection.");
        }
        rediriger(['action' => 'detailsCollection', 'id' => $idCollection]);
    }

    /** Retire un jeu de la collection (le jeu reste dans le catalogue). */
    public function retirerJeuCollection($idCollection, $idJeu) {
        $this->collectionDeLUtilisateur($idCollection);
        CollectionDAO::retirerJeu($idCollection, $idJeu);
        flash("Jeu retiré de la collection.");
        rediriger(['action' => 'detailsCollection', 'id' => $idCollection]);
    }
}
