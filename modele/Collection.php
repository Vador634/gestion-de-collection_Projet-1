<?php
// modele/collection.php
class Collection {
    public $idCollection;
    public $nomCollection;
    public $DateCreation;
    public $etat;
    public $notePerso;
    public $idUtilisateur;

    public function __construct($id = null, $nom = null, $date = null, $etat = null, $note = null, $idUtilisateur = null) {
        $this->idCollection = $id;
        $this->nomCollection = $nom;
        $this->DateCreation = $date;
        $this->etat = $etat;
        $this->notePerso = $note;
        $this->idUtilisateur = $idUtilisateur;
    }
}
