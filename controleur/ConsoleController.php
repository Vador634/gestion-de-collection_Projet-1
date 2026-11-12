<?php
class ConsoleController {
    public function lister() {
        $consoles = ConsoleDAO::getAll();
        $pageTitle = "Consoles";
        include __DIR__ . "/../vue/console/Liste.php";
    }

    public function details($id) {
        $console = $this->consoleOu404($id);
        $nbJeux = ConsoleDAO::countJeux($id);
        $pageTitle = $console->getNomConsole();
        include __DIR__ . "/../vue/console/Details.php";
    }

    public function ajouter() {
        $nomConsole = '';
        $fabricant = '';
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nomConsole = trim((string)($_POST["nomConsole"] ?? ''));
            $fabricant = trim((string)($_POST["fabricant"] ?? ''));
            $erreur = $this->valider($nomConsole, $fabricant);
            if (!$erreur) {
                ConsoleDAO::insert($nomConsole, $fabricant);
                flash("Console « $nomConsole » ajoutée.");
                rediriger(['action' => 'listerConsoles']);
            }
        }
        $pageTitle = "Ajouter une console";
        include __DIR__ . "/../vue/console/Ajouter.php";
    }

    public function modifier($id) {
        $console = $this->consoleOu404($id);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nomConsole = trim((string)($_POST["nomConsole"] ?? ''));
            $fabricant = trim((string)($_POST["fabricant"] ?? ''));
            $erreur = $this->valider($nomConsole, $fabricant);
            if (!$erreur) {
                ConsoleDAO::update($id, $nomConsole, $fabricant);
                flash("Console modifiée.");
                rediriger(['action' => 'detailsConsole', 'id' => $id]);
            }
            $console = new Console($id, $nomConsole, $fabricant);
        }
        $pageTitle = "Modifier une console";
        include __DIR__ . "/../vue/console/Modifier.php";
    }

    public function supprimer($id) {
        $console = $this->consoleOu404($id);
        ConsoleDAO::delete($id);
        flash("Console « {$console->getNomConsole()} » supprimée.");
        rediriger(['action' => 'listerConsoles']);
    }

    private function valider($nom, $fabricant) {
        if ($nom === '' || $fabricant === '') return "Tous les champs sont obligatoires.";
        if (longueur($nom) > 100 || longueur($fabricant) > 100) return "100 caractères maximum par champ.";
        return null;
    }

    private function consoleOu404($id) {
        $console = ConsoleDAO::getById($id);
        if (!$console) page_erreur(404, "Console introuvable.");
        return $console;
    }
}
