<?php
// modele/Collection.php
class Collection {
    public $idCollection;
    public $nomCollection;
    public $dateCreation;
    public $notePerso;
    public $idUtilisateur;

    public function __construct(
        $idCollection = null,
        $nomCollection = null,
        $dateCreation = null,
        $notePerso = null,
        $idUtilisateur = null
    ) {
        $this->idCollection = $idCollection;
        $this->nomCollection = $nomCollection;
        $this->dateCreation = $dateCreation;
        $this->notePerso = $notePerso;
        $this->idUtilisateur = $idUtilisateur;
    }
}

