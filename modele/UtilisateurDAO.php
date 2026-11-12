<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/Utilisateur.php';

class UtilisateurDAO {
    private $conn;

    public function __construct() {
        $this->conn = connexionPDO();
    }

    private static function versUtilisateur(array $row) {
        return new Utilisateur(
            $row['idUtilisateur'],
            $row['nom'],
            $row['prenom'],
            $row['mailUtilisateur'],
            $row['pseudo'],
            $row['motDePasse']
        );
    }

    /** L'adresse e-mail est-elle déjà utilisée ? */
    public function emailExiste($email) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM Utilisateur WHERE mailUtilisateur = :email");
        $stmt->execute([':email' => $email]);
        return (int)$stmt->fetchColumn() > 0;
    }

    /**
     * Inscription d'un nouvel utilisateur (mot de passe haché).
     * @return int|false identifiant du nouvel utilisateur
     */
    public function inscrire(Utilisateur $u) {
        $stmt = $this->conn->prepare(
            "INSERT INTO Utilisateur (mailUtilisateur, motDePasse, pseudo, description, nom, prenom)
             VALUES (:email, :motDePasse, :pseudo, '', :nom, :prenom)"
        );
        $stmt->bindValue(':email', $u->getEmail());
        $stmt->bindValue(':motDePasse', password_hash($u->getMotDePasse(), PASSWORD_DEFAULT));
        $stmt->bindValue(':pseudo', $u->getPseudo());
        $stmt->bindValue(':nom', $u->getNom());
        $stmt->bindValue(':prenom', $u->getPrenom());

        return $stmt->execute() ? (int)$this->conn->lastInsertId() : false;
    }

    /**
     * Connexion d'un utilisateur existant.
     *
     * Les anciens comptes de test enregistrés avec un mot de passe en clair
     * restent utilisables : à leur première connexion, le mot de passe est
     * automatiquement haché. Une valeur déjà hachée n'est jamais comparée
     * telle quelle (connaître le hash ne permet pas de se connecter).
     *
     * @return Utilisateur|null
     */
    public function connecter($email, $motDePasse) {
        $stmt = $this->conn->prepare("SELECT * FROM Utilisateur WHERE mailUtilisateur = :email");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        $stocke = $row['motDePasse'];
        $estHache = !empty(password_get_info($stocke)['algo']);

        if ($estHache) {
            if (!password_verify($motDePasse, $stocke)) return null;
            if (password_needs_rehash($stocke, PASSWORD_DEFAULT)) {
                $this->changerMotDePasse($row['idUtilisateur'], $motDePasse);
            }
        } else {
            if (!hash_equals((string)$stocke, (string)$motDePasse)) return null;
            $this->changerMotDePasse($row['idUtilisateur'], $motDePasse); // migration vers un hash
        }

        return self::versUtilisateur($row);
    }

    private function changerMotDePasse($id, $motDePasse) {
        $stmt = $this->conn->prepare("UPDATE Utilisateur SET motDePasse = :mdp WHERE idUtilisateur = :id");
        $stmt->execute([':mdp' => password_hash($motDePasse, PASSWORD_DEFAULT), ':id' => $id]);
    }

    /** @return Utilisateur|null */
    public function trouverParId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Utilisateur WHERE idUtilisateur = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? self::versUtilisateur($row) : null;
    }
}
