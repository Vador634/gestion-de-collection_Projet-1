<?php
class ConsoleController {
    public function lister() {
        $consoles = ConsoleDAO::getAll();
        include __DIR__ . "/../vue/console/Liste.php";
    }

    public function details($id) {
        $console = ConsoleDAO::getById($id);
        if (!$console) {
            header("HTTP/1.0 404 Not Found");
            echo "Console introuvable.";
            exit;
        }
        include __DIR__ . "/../vue/console/Details.php";
    }

    public function ajouter() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nomConsole = $_POST["nomConsole"] ?? '';
            $fabricant = $_POST["fabricant"] ?? '';
            
            if ($nomConsole === '' || $fabricant === '') {
                $erreur = "Tous les champs sont obligatoires.";
                include __DIR__ . "/../vue/console/Ajouter.php";
                return;
            }
            
            ConsoleDAO::insert($nomConsole, $fabricant);
            header("Location: " . url('Index.php', ['action' => 'listerConsoles']));
            exit;
        }
        include __DIR__ . "/../vue/console/Ajouter.php";
    }

    public function modifier($id) {
        $console = ConsoleDAO::getById($id);
        if (!$console) {
            echo "Console introuvable.";
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nomConsole = $_POST["nomConsole"] ?? '';
            $fabricant = $_POST["fabricant"] ?? '';
            
            ConsoleDAO::update($id, $nomConsole, $fabricant);
            header("Location: " . url('Index.php', ['action' => 'detailsConsole', 'id' => $id]));
            exit;
        }
        include __DIR__ . "/../vue/console/Modifier.php";
    }

    public function supprimer($id) {
        ConsoleDAO::delete($id);
        header("Location: " . url('Index.php', ['action' => 'listerConsoles']));
        exit;
    }
}



