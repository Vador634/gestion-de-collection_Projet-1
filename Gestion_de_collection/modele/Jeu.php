<?php
class Jeu {
    public $idJeu;
    public $titre;
    public $anneeSortie;
    public $prixEstime;

    public function __construct($idJeu, $titre, $anneeSortie, $prixEstime) {
        $this->idJeu = $idJeu;
        $this->titre = $titre;
        $this->anneeSortie = $anneeSortie;
        $this->prixEstime = $prixEstime;
    }
}


