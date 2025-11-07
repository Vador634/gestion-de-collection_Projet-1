<?php
require_once __DIR__ . "/../modele/ConsoleDAO.php";

class ConsoleController {
    public function lister() {
        $consoles = ConsoleDAO::getAll();
        include __DIR__ . "/../vue/console/liste.php";
    }

    public function details($id) {
        $console = ConsoleDAO::getById($id);
        if (!$console) {
            header("HTTP/1.0 404 Not Found");
            echo "Console introuvable.";
            exit;
        }
        include __DIR__ . "/../vue/console/details.php";
    }

    public function ajouter() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nomConsole = $_POST["nomConsole"] ?? '';
            $constructeur = $_POST["constructeur"] ?? '';
            
            if ($nomConsole === '' || $constructeur === '') {
                $erreur = "Tous les champs sont obligatoires.";
                include __DIR__ . "/../vue/console/ajouter.php";
                return;
            }
            
            ConsoleDAO::insert($nomConsole, $constructeur);
            header("Location: Index.php?action=listerConsoles");
            exit;
        }
        include __DIR__ . "/../vue/console/ajouter.php";
    }

    public function modifier($id) {
        $console = ConsoleDAO::getById($id);
        if (!$console) {
            echo "Console introuvable.";
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nomConsole = $_POST["nomConsole"] ?? '';
            $constructeur = $_POST["constructeur"] ?? '';
            
            ConsoleDAO::update($id, $nomConsole, $constructeur);
            header("Location: Index.php?action=detailsConsole&id=" . $id);
            exit;
        }
        include __DIR__ . "/../vue/console/modifier.php";
    }

    public function supprimer($id) {
        ConsoleDAO::delete($id);
        header("Location: Index.php?action=listerConsoles");
        exit;
    }
}



