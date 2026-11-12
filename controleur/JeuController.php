<?php
/**
 * Catalogue de jeux partagé entre les utilisateurs.
 */
class JeuController {

    /** Liste de tous les jeux. */
    public function liste() {
        $jeux = JeuDAO::getAll();
        $consolesParJeu = [];
        foreach ($jeux as $jeu) {
            $consolesParJeu[$jeu->getIdJeu()] = JeuDAO::getConsoles($jeu->getIdJeu());
        }
        $pageTitle = "Catalogue de jeux";
        include __DIR__ . "/../vue/jeu/Liste.php";
    }

    /** Détails d'un jeu, avec les libellés de ses références. */
    public function details($id) {
        $jeu = $this->jeuOu404($id);
        $consoles = JeuDAO::getConsoles($id);
        $genres = JeuDAO::getGenres($id);
        $editeurs = JeuDAO::getEditeurs($id);
        $condition = $jeu->getIdCondition() ? ConditionDAO::getById($jeu->getIdCondition()) : null;
        $rarete = $jeu->getIdRarete() ? RareteDAO::getById($jeu->getIdRarete()) : null;
        $developpeur = $jeu->getIdDeveloppeur() ? DeveloppeurDAO::getById($jeu->getIdDeveloppeur()) : null;
        $nbCollections = JeuDAO::countCollections($id);
        $pageTitle = $jeu->getTitre();
        include __DIR__ . "/../vue/jeu/Details.php";
    }

    /** Ajout d'un jeu, éventuellement directement dans une collection. */
    public function ajouter() {
        $idCollection = filter_input(INPUT_GET, 'idCollection', FILTER_VALIDATE_INT)
            ?: filter_input(INPUT_POST, 'idCollection', FILTER_VALIDATE_INT) ?: null;
        if ($idCollection) {
            $collection = CollectionDAO::getById($idCollection);
            if (!$collection || (int)$collection->idUtilisateur !== utilisateur_id()) {
                $idCollection = null; // on n'ajoute jamais dans la collection d'un autre
            }
        }

        $this->chargerListes($conditions, $raretes, $developpeurs, $consoles, $genres, $editeurs);
        $valeurs = ['titre' => '', 'anneeSortie' => '', 'prixEstime' => '', 'idCondition' => null, 'idRarete' => null,
                    'idDeveloppeur' => null, 'consoles' => [], 'genres' => [], 'editeurs' => []];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $valeurs = $this->lireFormulaire($erreur);
            if (!$erreur) {
                $cnx = connexionPDO();
                $cnx->beginTransaction();
                try {
                    $newId = JeuDAO::insert($valeurs['titre'], $valeurs['anneeSortie'], $valeurs['prixEstime'],
                                            $valeurs['idCondition'], $valeurs['idRarete'], $valeurs['idDeveloppeur']);
                    JeuDAO::setConsoles($newId, $valeurs['consoles']);
                    JeuDAO::setGenres($newId, $valeurs['genres']);
                    JeuDAO::setEditeurs($newId, $valeurs['editeurs']);
                    if ($idCollection) {
                        CollectionDAO::ajouterJeu($idCollection, $newId);
                    }
                    $cnx->commit();
                } catch (Exception $e) {
                    $cnx->rollBack();
                    throw $e;
                }

                flash("Jeu « {$valeurs['titre']} » ajouté" . ($idCollection ? " à la collection." : " au catalogue."));
                rediriger($idCollection ? ['action' => 'detailsCollection', 'id' => $idCollection] : ['action' => 'detailsJeu', 'id' => $newId]);
            }
        }

        $pageTitle = "Ajouter un jeu";
        include __DIR__ . "/../vue/jeu/Ajouter.php";
    }

    /** Modification d'un jeu. */
    public function modifier($id) {
        $jeu = $this->jeuOu404($id);
        $this->chargerListes($conditions, $raretes, $developpeurs, $consoles, $genres, $editeurs);

        $ids = function ($liste, $getter) {
            return array_map(function ($o) use ($getter) { return (int)$o->$getter(); }, $liste);
        };
        $valeurs = [
            'titre' => $jeu->getTitre(),
            'anneeSortie' => $jeu->getAnneeSortie(),
            'prixEstime' => $jeu->getPrixEstime(),
            'idCondition' => $jeu->getIdCondition(),
            'idRarete' => $jeu->getIdRarete(),
            'idDeveloppeur' => $jeu->getIdDeveloppeur(),
            'consoles' => $ids(JeuDAO::getConsoles($id), 'getIdConsole'),
            'genres' => $ids(JeuDAO::getGenres($id), 'getIdGenre'),
            'editeurs' => array_map(function ($e) { return (int)$e->idEditeur; }, JeuDAO::getEditeurs($id)),
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $valeurs = $this->lireFormulaire($erreur);
            if (!$erreur) {
                $cnx = connexionPDO();
                $cnx->beginTransaction();
                try {
                    JeuDAO::update($id, $valeurs['titre'], $valeurs['anneeSortie'], $valeurs['prixEstime'],
                                   $valeurs['idCondition'], $valeurs['idRarete'], $valeurs['idDeveloppeur']);
                    JeuDAO::setConsoles($id, $valeurs['consoles']);
                    JeuDAO::setGenres($id, $valeurs['genres']);
                    JeuDAO::setEditeurs($id, $valeurs['editeurs']);
                    $cnx->commit();
                } catch (Exception $e) {
                    $cnx->rollBack();
                    throw $e;
                }
                flash("Jeu modifié.");
                rediriger(['action' => 'detailsJeu', 'id' => $id]);
            }
        }

        $pageTitle = "Modifier un jeu";
        include __DIR__ . "/../vue/jeu/Modifier.php";
    }

    /** Suppression d'un jeu (POST uniquement) : il est aussi retiré des collections. */
    public function supprimer($id) {
        $jeu = $this->jeuOu404($id);
        JeuDAO::delete($id);
        flash("Jeu « {$jeu->getTitre()} » supprimé.");
        rediriger(['action' => 'listeJeux']);
    }

    // ---------------------------------------------------------------

    private function jeuOu404($id) {
        $jeu = JeuDAO::getById($id);
        if (!$jeu) {
            page_erreur(404, "Jeu introuvable.");
        }
        return $jeu;
    }

    private function chargerListes(&$conditions, &$raretes, &$developpeurs, &$consoles, &$genres, &$editeurs) {
        $conditions = ConditionDAO::getAll();
        $raretes = RareteDAO::getAll();
        $developpeurs = DeveloppeurDAO::getAll();
        $consoles = ConsoleDAO::getAll();
        $genres = GenreDAO::getAll();
        $editeurs = EditeurDAO::getAll();
    }

    /** Lit et valide le formulaire d'un jeu (ajout ou modification). */
    private function lireFormulaire(&$erreur) {
        $entierOuNull = function ($nom) {
            $v = filter_input(INPUT_POST, $nom, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
            return $v ?: null;
        };
        $liste = function ($nom) {
            return isset($_POST[$nom]) && is_array($_POST[$nom]) ? $_POST[$nom] : [];
        };

        $anneeBrute = trim((string)($_POST['anneeSortie'] ?? ''));
        $prixBrut = str_replace(',', '.', trim((string)($_POST['prixEstime'] ?? '')));

        $valeurs = [
            'titre' => trim((string)($_POST['titre'] ?? '')),
            'anneeSortie' => $anneeBrute === '' ? null : filter_var($anneeBrute, FILTER_VALIDATE_INT),
            'prixEstime' => $prixBrut === '' ? null : filter_var($prixBrut, FILTER_VALIDATE_FLOAT),
            'idCondition' => $entierOuNull('idCondition'),
            'idRarete' => $entierOuNull('idRarete'),
            'idDeveloppeur' => $entierOuNull('idDeveloppeur'),
            'consoles' => $liste('consoles'),
            'genres' => $liste('genres'),
            'editeurs' => $liste('editeurs'),
        ];

        $erreur = null;
        if ($valeurs['titre'] === '') {
            $erreur = "Le titre est obligatoire.";
        } elseif (longueur($valeurs['titre']) > 150) {
            $erreur = "Le titre ne doit pas dépasser 150 caractères.";
        } elseif ($valeurs['anneeSortie'] === false || ($valeurs['anneeSortie'] !== null && ($valeurs['anneeSortie'] < 1901 || $valeurs['anneeSortie'] > 2155))) {
            $erreur = "L'année de sortie doit être comprise entre 1901 et 2155.";
        } elseif ($valeurs['prixEstime'] === false || ($valeurs['prixEstime'] !== null && $valeurs['prixEstime'] < 0)) {
            $erreur = "Le prix estimé doit être un nombre positif.";
        }
        return $valeurs;
    }
}
