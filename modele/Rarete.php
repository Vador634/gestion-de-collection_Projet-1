<?php
// modele/Rarete.php
class Rarete {
    public $idRarete;
    public $libelleRarete;

    public function __construct($idRarete = null, $libelleRarete = null) {
        $this->idRarete = $idRarete;
        $this->libelleRarete = $libelleRarete;
    }
}
