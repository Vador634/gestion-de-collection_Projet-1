<?php
class Jeu {
    private $idJeu;
    private $titre;
    private $anneeSortie;
    private $prixEstime;
    private $idCondition;      // référence vers ConditionJeu
    private $idRarete;         // référence vers Rarete
    private $idDeveloppeur;    // référence vers Developpeur

    public function __construct($idJeu, $titre, $anneeSortie, $prixEstime, $idCondition = null, $idRarete = null, $idDeveloppeur = null) {
        $this->idJeu = $idJeu;
        $this->titre = $titre;
        $this->anneeSortie = $anneeSortie;
        $this->prixEstime = $prixEstime;
        $this->idCondition = $idCondition;
        $this->idRarete = $idRarete;
        $this->idDeveloppeur = $idDeveloppeur;
    }

    // Getters
    public function getIdJeu() { return $this->idJeu; }
    public function getTitre() { return $this->titre; }
    public function getAnneeSortie() { return $this->anneeSortie; }
    public function getPrixEstime() { return $this->prixEstime; }
    public function getIdCondition() { return $this->idCondition; }
    public function getIdRarete() { return $this->idRarete; }
    public function getIdDeveloppeur() { return $this->idDeveloppeur; }

    // Setters
    public function setTitre($titre) { $this->titre = $titre; }
    public function setAnneeSortie($anneeSortie) { $this->anneeSortie = $anneeSortie; }
    public function setPrixEstime($prixEstime) { $this->prixEstime = $prixEstime; }
    public function setIdCondition($idCondition) { $this->idCondition = $idCondition; }
    public function setIdRarete($idRarete) { $this->idRarete = $idRarete; }
    public function setIdDeveloppeur($idDeveloppeur) { $this->idDeveloppeur = $idDeveloppeur; }
}



