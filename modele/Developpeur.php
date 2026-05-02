<?php
// modele/Developpeur.php
class Developpeur {
    public $idDeveloppeur;
    public $libelleDeveloppeur;

    public function __construct($idDeveloppeur = null, $libelleDeveloppeur = null) {
        $this->idDeveloppeur = $idDeveloppeur;
        $this->libelleDeveloppeur = $libelleDeveloppeur;
    }
}
