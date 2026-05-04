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
     * 
     * @param Utilisateur $u Objet Utilisateur à insérer
     * @return int|bool L'ID du nouvel utilisateur ou false en cas d'échec
     */
    public function inscrire(Utilisateur $u) {
        // Sécurisation : hachage du mot de passe
        $motDePasseHash = password_hash($u->getMotDePasse(), PASSWORD_BCRYPT);

        // Délégation de l'ID à l'AUTO_INCREMENT de la base de données
        $query = "INSERT INTO Utilisateur (mailUtilisateur, motDePasse, pseudo, description, nom, prenom)
                  VALUES (:email, :motDePasse, :pseudo, '', :nom, :prenom)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':email', $u->getEmail());
        $stmt->bindValue(':motDePasse', $motDePasseHash);
        $stmt->bindValue(':pseudo', $u->getPseudo());
        $stmt->bindValue(':nom', $u->getNom());
        $stmt->bindValue(':prenom', $u->getPrenom());

        return $stmt->execute() ? (int)$this->conn->lastInsertId() : false;
    }

    /**
     * Connexion d’un utilisateur existant
     * 
     * @param string $email
     * @param string $motDePasse Mot de passe en clair
     * @return Utilisateur|null
     */
    public function connecter($email, $motDePasse) {
        $query = "SELECT * FROM Utilisateur WHERE mailUtilisateur = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([":email" => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification sécurisée (et option de fallback pour les tests précédents non-hachés)
        if ($row && (password_verify($motDePasse, $row['motDePasse']) || $row['motDePasse'] === $motDePasse)) {
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
     * 
     * @param int $id
     * @return Utilisateur|null
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
