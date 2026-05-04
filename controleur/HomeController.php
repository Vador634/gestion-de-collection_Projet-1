<?php
class HomeController {
    /**
     * Affiche la page d'accueil.
     */
    public function index() {
        $pageTitle = "Accueil";
        include __DIR__ . "/../vue/Home.php";
    }
}