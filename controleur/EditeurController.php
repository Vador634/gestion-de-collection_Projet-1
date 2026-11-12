<?php
class EditeurController {
    public function lister() {
        $editeurs = EditeurDAO::getAll();
        $pageTitle = "Éditeurs";
        include __DIR__ . "/../vue/editeur/Liste.php";
    }

    public function details($id) {
        $editeur = $this->editeurOu404($id);
        $nbJeux = EditeurDAO::countJeux($id);
        $pageTitle = $editeur->libelleEditeur;
        include __DIR__ . "/../vue/editeur/Details.php";
    }

    public function ajouter() {
        $libelleEditeur = '';
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $libelleEditeur = trim((string)($_POST['libelleEditeur'] ?? ''));
            $erreur = $this->valider($libelleEditeur);
            if (!$erreur) {
                EditeurDAO::insert($libelleEditeur);
                flash("Éditeur « $libelleEditeur » ajouté.");
                rediriger(['action' => 'listerEditeurs']);
            }
        }
        $pageTitle = "Ajouter un éditeur";
        include __DIR__ . "/../vue/editeur/Ajouter.php";
    }

    public function modifier($id) {
        $editeur = $this->editeurOu404($id);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $libelleEditeur = trim((string)($_POST['libelleEditeur'] ?? ''));
            $erreur = $this->valider($libelleEditeur);
            if (!$erreur) {
                EditeurDAO::update($id, $libelleEditeur);
                flash("Éditeur modifié.");
                rediriger(['action' => 'detailsEditeur', 'id' => $id]);
            }
            $editeur = new Editeur($id, $libelleEditeur);
        }
        $pageTitle = "Modifier un éditeur";
        include __DIR__ . "/../vue/editeur/Modifier.php";
    }

    public function supprimer($id) {
        $editeur = $this->editeurOu404($id);
        EditeurDAO::delete($id);
        flash("Éditeur « {$editeur->libelleEditeur} » supprimé.");
        rediriger(['action' => 'listerEditeurs']);
    }

    private function valider($libelleEditeur) {
        if ($libelleEditeur === '') return "Le nom de l'éditeur est obligatoire.";
        if (longueur($libelleEditeur) > 100) return "100 caractères maximum.";
        return null;
    }

    private function editeurOu404($id) {
        $editeur = EditeurDAO::getById($id);
        if (!$editeur) page_erreur(404, "Éditeur introuvable.");
        return $editeur;
    }
}
