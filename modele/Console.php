<?php
class Console {
    private $idConsole;
    private $nomConsole;
    private $constructeur;

    public function __construct($idConsole, $nomConsole, $constructeur) {
        $this->idConsole = $idConsole;
        $this->nomConsole = $nomConsole;
        $this->constructeur = $constructeur;
    }

    public function getIdConsole() { return $this->idConsole; }
    public function getNomConsole() { return $this->nomConsole; }
    public function getConstructeur() { return $this->constructeur; }
}
