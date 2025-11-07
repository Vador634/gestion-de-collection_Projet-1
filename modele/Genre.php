<?php
class Genre {
    private $idGenre;
    private $nomGenre;

    public function __construct($idGenre, $nomGenre) {
        $this->idGenre = $idGenre;
        $this->nomGenre = $nomGenre;
    }

    public function getIdGenre() { return $this->idGenre; }
    public function getNomGenre() { return $this->nomGenre; }
}

