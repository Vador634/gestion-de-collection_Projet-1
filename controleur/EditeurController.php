<?php
class EditeurController {
    public function lister() {
        $editeurs = EditeurDAO::getAll();
        include __DIR__ . "/../vue/editeur/Liste.php";
    }

    public function details($id) {
        $editeur = EditeurDAO::getById($id);
        if (!$editeur) {
            header("HTTP/1.0 404 Not Found");
            echo "Éditeur introuvable.";
            exit;
        }
        include __DIR__ . "/../vue/editeur/Details.php";
    }

    public function ajouter() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $libelle = trim($_POST['libelleEditeur'] ?? '');
            if ($libelle === '') {
                $erreur = "Le nom de l'éditeur est obligatoire.";
                include __DIR__ . "/../vue/editeur/Ajouter.php";
                return;
            }
            EditeurDAO::insert($libelle);
            header("Location: " . url('Index.php',['action'=>'listerEditeurs']));
            exit;
        }
        include __DIR__ . "/../vue/editeur/Ajouter.php";
    }

    public function modifier($id) {
        $editeur = EditeurDAO::getById($id);
        if (!$editeur) {
            echo "Éditeur introuvable.";
            exit;
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $libelle = trim($_POST['libelleEditeur'] ?? '');
            EditeurDAO::update($id, $libelle);
            header("Location: " . url('Index.php',['action'=>'detailsEditeur','id'=>$id]));
            exit;
        }
        include __DIR__ . "/../vue/editeur/Modifier.php";
    }

    public function supprimer($id) {
        EditeurDAO::delete($id);
        header("Location: " . url('Index.php',['action'=>'listerEditeurs']));
        exit;
    }
}
