<?php
class UtilisateurController {
    private $dao;

    public function __construct() {
        $this->dao = new UtilisateurDAO();
    }

    /**
     * Page de connexion
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            include __DIR__ . '/../vue/utilisateur/Login.php';
            return;
        }

        $email = trim((string)($_POST['email'] ?? ''));
        $motDePasse = (string)($_POST['motDePasse'] ?? '');

        if ($email === '' || $motDePasse === '') {
            $erreur = "Tous les champs sont obligatoires.";
            include __DIR__ . '/../vue/utilisateur/Login.php';
            return;
        }

        $utilisateur = $this->dao->connecter($email, $motDePasse);
        if (!$utilisateur) {
            $erreur = "Email ou mot de passe incorrect.";
            include __DIR__ . '/../vue/utilisateur/Login.php';
            return;
        }

        $this->ouvrirSession($utilisateur->getId(), $utilisateur->getNom(), $utilisateur->getPrenom(), $utilisateur->getPseudo(), $utilisateur->getEmail());
        flash("Bienvenue " . $utilisateur->getPseudo() . " !");
        rediriger();
    }

    /**
     * Page d'inscription
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            include __DIR__ . '/../vue/utilisateur/Register.php';
            return;
        }

        $nom = trim((string)($_POST['nom'] ?? ''));
        $prenom = trim((string)($_POST['prenom'] ?? ''));
        $pseudo = trim((string)($_POST['pseudo'] ?? ''));
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $motDePasse = (string)($_POST['motDePasse'] ?? '');

        if ($nom === '' || $prenom === '' || $pseudo === '' || !$email || $motDePasse === '') {
            $erreur = "Tous les champs sont obligatoires et l'email doit être valide.";
        } elseif (strlen($nom) > 50 || strlen($prenom) > 50 || strlen($pseudo) > 50 || strlen($email) > 100) {
            $erreur = "Un des champs est trop long (50 caractères maximum, 100 pour l'email).";
        } elseif (strlen($motDePasse) < 8) {
            $erreur = "Le mot de passe doit contenir au moins 8 caractères.";
        } elseif ($this->dao->emailExiste($email)) {
            $erreur = "Un compte existe déjà avec cette adresse email.";
        }
        if (isset($erreur)) {
            include __DIR__ . '/../vue/utilisateur/Register.php';
            return;
        }

        $id = $this->dao->inscrire(new Utilisateur(null, $nom, $prenom, $email, $pseudo, $motDePasse));
        if (!$id) {
            $erreur = "Erreur lors de l'inscription. Veuillez réessayer.";
            include __DIR__ . '/../vue/utilisateur/Register.php';
            return;
        }

        $this->ouvrirSession($id, $nom, $prenom, $pseudo, $email);
        flash("Compte créé, bienvenue $pseudo !");
        rediriger();
    }

    /** Nouvel identifiant de session à la connexion (évite la fixation de session). */
    private function ouvrirSession($id, $nom, $prenom, $pseudo, $email) {
        session_regenerate_id(true);
        $_SESSION['utilisateur'] = [
            'id' => (int)$id,
            'nom' => $nom,
            'prenom' => $prenom,
            'pseudo' => $pseudo,
            'email' => $email
        ];
    }

    /**
     * Déconnexion
     */
    public function logout() {
        $_SESSION = [];
        session_destroy();
        rediriger();
    }

    /**
     * Profil de l'utilisateur connecté
     */
    public function profil() {
        $utilisateur = $this->dao->trouverParId(utilisateur_id());
        if (!$utilisateur) {
            $this->logout();
        }
        $nbCollections = count(CollectionDAO::getByUser(utilisateur_id()));
        include __DIR__ . '/../vue/utilisateur/Profil.php';
    }
}
