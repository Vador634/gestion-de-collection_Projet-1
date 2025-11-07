<?php
class Jeu {
    private $idJeu;
    private $titre;
    private $anneeSortie;
    private $prixEstime;

    public function __construct($idJeu, $titre, $anneeSortie, $prixEstime) {
        $this->idJeu = $idJeu;
        $this->titre = $titre;
        $this->anneeSortie = $anneeSortie;
        $this->prixEstime = $prixEstime;
    }

    // Getters
    public function getIdJeu() { return $this->idJeu; }
    public function getTitre() { return $this->titre; }
    public function getAnneeSortie() { return $this->anneeSortie; }
    public function getPrixEstime() { return $this->prixEstime; }

    // Setters
    public function setTitre($titre) { $this->titre = $titre; }
    public function setAnneeSortie($anneeSortie) { $this->anneeSortie = $anneeSortie; }
    public function setPrixEstime($prixEstime) { $this->prixEstime = $prixEstime; }
}



