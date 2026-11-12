<?php
class GenreController {
    public function lister() {
        $genres = GenreDAO::getAll();
        $pageTitle = "Genres";
        include __DIR__ . "/../vue/genre/Liste.php";
    }

    public function details($id) {
        $genre = $this->genreOu404($id);
        $nbJeux = GenreDAO::countJeux($id);
        $pageTitle = $genre->getNomGenre();
        include __DIR__ . "/../vue/genre/Details.php";
    }

    public function ajouter() {
        $nomGenre = '';
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nomGenre = trim((string)($_POST["nomGenre"] ?? ''));
            $erreur = $this->valider($nomGenre);
            if (!$erreur) {
                GenreDAO::insert($nomGenre);
                flash("Genre « $nomGenre » ajouté.");
                rediriger(['action' => 'listerGenres']);
            }
        }
        $pageTitle = "Ajouter un genre";
        include __DIR__ . "/../vue/genre/Ajouter.php";
    }

    public function modifier($id) {
        $genre = $this->genreOu404($id);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nomGenre = trim((string)($_POST["nomGenre"] ?? ''));
            $erreur = $this->valider($nomGenre);
            if (!$erreur) {
                GenreDAO::update($id, $nomGenre);
                flash("Genre modifié.");
                rediriger(['action' => 'detailsGenre', 'id' => $id]);
            }
            $genre = new Genre($id, $nomGenre);
        }
        $pageTitle = "Modifier un genre";
        include __DIR__ . "/../vue/genre/Modifier.php";
    }

    public function supprimer($id) {
        $genre = $this->genreOu404($id);
        GenreDAO::delete($id);
        flash("Genre « {$genre->getNomGenre()} » supprimé.");
        rediriger(['action' => 'listerGenres']);
    }

    private function valider($nom) {
        if ($nom === '') return "Le nom du genre est obligatoire.";
        if (longueur($nom) > 100) return "100 caractères maximum.";
        return null;
    }

    private function genreOu404($id) {
        $genre = GenreDAO::getById($id);
        if (!$genre) page_erreur(404, "Genre introuvable.");
        return $genre;
    }
}
