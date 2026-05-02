<?php
class Console {
    private $idConsole;
    private $nomConsole;
    private $fabricant;

    public function __construct($idConsole, $nomConsole, $fabricant) {
        $this->idConsole = $idConsole;
        $this->nomConsole = $nomConsole;
        $this->fabricant = $fabricant;
    }

    public function getIdConsole() { return $this->idConsole; }
    public function getNomConsole() { return $this->nomConsole; }
    public function getFabricant() { return $this->fabricant; }
}
