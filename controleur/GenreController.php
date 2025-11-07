<?php
require_once __DIR__ . "/../modele/GenreDAO.php";

class GenreController {
    public function lister() {
        $genres = GenreDAO::getAll();
        include __DIR__ . "/../vue/genre/liste.php";
    }

    public function details($id) {
        $genre = GenreDAO::getById($id);
        if (!$genre) {
            header("HTTP/1.0 404 Not Found");
            echo "Genre introuvable.";
            exit;
        }
        include __DIR__ . "/../vue/genre/details.php";
    }

    public function ajouter() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nomGenre = $_POST["nomGenre"] ?? '';
            
            if ($nomGenre === '') {
                $erreur = "Le nom du genre est obligatoire.";
                include __DIR__ . "/../vue/genre/ajouter.php";
                return;
            }
            
            GenreDAO::insert($nomGenre);
            header("Location: Index.php?action=listerGenres");
            exit;
        }
        include __DIR__ . "/../vue/genre/ajouter.php";
    }

    public function modifier($id) {
        $genre = GenreDAO::getById($id);
        if (!$genre) {
            echo "Genre introuvable.";
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nomGenre = $_POST["nomGenre"] ?? '';
            
            GenreDAO::update($id, $nomGenre);
            header("Location: Index.php?action=detailsGenre&id=" . $id);
            exit;
        }
        include __DIR__ . "/../vue/genre/modifier.php";
    }

    public function supprimer($id) {
        GenreDAO::delete($id);
        header("Location: Index.php?action=listerGenres");
        exit;
    }
}
