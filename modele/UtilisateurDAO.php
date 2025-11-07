<?php
require_once __DIR__ . '/../config/Database.php';
require_once 'Utilisateur.php';

class UtilisateurDAO {
    private $conn;

    public function __construct() {
        $this->conn = connexionPDO();
    }

    /**
     * Inscription d'un nouvel utilisateur
     */
    public function inscrire(Utilisateur $u) {
        $query = "SELECT MAX(idUtilisateur) AS dernier_id FROM Utilisateur";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $nouvel_id = ($result['dernier_id'] ?? 0) + 1;
        $motDePasse = $u->getMotDePasse(); // pas de hash pour le jeu d'essai

        $query = "INSERT INTO Utilisateur (idUtilisateur, mailUtilisateur, motDePasse, pseudo, description, nom, prenom)
                  VALUES (:id, :email, :motDePasse, :pseudo, '', :nom, :prenom)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':id', $nouvel_id, PDO::PARAM_INT);
        $stmt->bindValue(':email', $u->getEmail());
        $stmt->bindValue(':motDePasse', $motDePasse);
        $stmt->bindValue(':pseudo', $u->getPseudo());
        $stmt->bindValue(':nom', $u->getNom());
        $stmt->bindValue(':prenom', $u->getPrenom());

        return $stmt->execute() ? $nouvel_id : false;
    }

    /**
     * Connexion d’un utilisateur existant
     */
    public function connecter($email, $motDePasse) {
        $query = "SELECT * FROM Utilisateur WHERE mailUtilisateur = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([":email" => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && $row['motDePasse'] === $motDePasse) {
            return new Utilisateur(
                $row['idUtilisateur'],
                $row['nom'],
                $row['prenom'],
                $row['mailUtilisateur'],
                $row['pseudo'],
                $row['motDePasse']
            );
        }
        return null;
    }

    /**
     * Trouver un utilisateur par ID
     */
    public function trouverParId($id) {
        $query = "SELECT * FROM Utilisateur WHERE idUtilisateur = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([":id" => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Utilisateur(
                $row['idUtilisateur'],
                $row['nom'],
                $row['prenom'],
                $row['mailUtilisateur'],
                $row['pseudo'],
                $row['motDePasse']
            );
        }
        return null;
    }
}
?>





