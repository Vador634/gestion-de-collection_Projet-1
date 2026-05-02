<?php
// modele/Editeur.php
class Editeur {
    public $idEditeur;
    public $libelleEditeur;

    public function __construct($idEditeur = null, $libelleEditeur = null) {
        $this->idEditeur = $idEditeur;
        $this->libelleEditeur = $libelleEditeur;
    }
}
