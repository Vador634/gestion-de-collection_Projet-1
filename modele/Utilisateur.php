<?php
class Utilisateur {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $pseudo;
    private $motDePasse;

    public function __construct($id = null, $nom, $prenom, $email, $pseudo, $motDePasse) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->pseudo = $pseudo;
        $this->motDePasse = $motDePasse;
    }

    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }
    public function getPseudo() { return $this->pseudo; }
    public function getMotDePasse() { return $this->motDePasse; }

    public function setNom($nom) { $this->nom = $nom; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }
    public function setEmail($email) { $this->email = $email; }
    public function setPseudo($pseudo) { $this->pseudo = $pseudo; }
    public function setMotDePasse($motDePasse) { $this->motDePasse = $motDePasse; }
}
?>

