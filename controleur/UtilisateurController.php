<?php
require_once __DIR__ . '/../modele/UtilisateurDAO.php';
require_once __DIR__ . '/../modele/Utilisateur.php';
require_once __DIR__ . '/../config/Database.php';

class UtilisateurController {
    private $dao;
    
    public function __construct() {
        $this->dao = new UtilisateurDAO();
    }
    
    /**
     * Page de connexion
     */
    public function login() {
        // ✅ Si GET : afficher le formulaire
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            include __DIR__ . '/../vue/utilisateur/Login.php';
            return;
        }
        
        // ✅ Si POST : traiter la connexion
        $email = $_POST['email'] ?? '';
        $motDePasse = $_POST['motDePasse'] ?? '';
        
        if ($email === '' || $motDePasse === '') {
            $erreur = "Tous les champs sont obligatoires.";
            include __DIR__ . '/../vue/utilisateur/Login.php';
            return;
        }
        
        $utilisateur = $this->dao->connecter($email, $motDePasse);
        
        if ($utilisateur) {
            $_SESSION['utilisateur'] = [
                'id' => $utilisateur->getId(),
                'nom' => $utilisateur->getNom(),
                'prenom' => $utilisateur->getPrenom(),
                'pseudo' => $utilisateur->getPseudo(),
                'email' => $utilisateur->getEmail()
            ];
            // ✅ Redirection vers la racine (Index.php est à la racine)
            header('Location: /~kcarasco/Gestion_de_collection/Index.php');
            exit;
        } else {
            $erreur = "Email ou mot de passe incorrect.";
            include __DIR__ . '/../vue/utilisateur/Login.php';
        }
    }
    
    /**
     * Page d'inscription
     */
    public function register() {
        // ✅ Si GET : afficher le formulaire
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            include __DIR__ . '/../vue/utilisateur/Register.php';
            return;
        }
        
        // ✅ Si POST : traiter l'inscription
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $pseudo = $_POST['pseudo'] ?? '';
        $email = $_POST['email'] ?? '';
        $motDePasse = $_POST['motDePasse'] ?? '';
        
        if ($nom === '' || $prenom === '' || $pseudo === '' || $email === '' || $motDePasse === '') {
            $erreur = "Tous les champs sont obligatoires.";
            include __DIR__ . '/../vue/utilisateur/Register.php';
            return;
        }
        
        $utilisateur = new Utilisateur(null, $nom, $prenom, $email, $pseudo, $motDePasse);
        $result = $this->dao->inscrire($utilisateur);
        
        if ($result) {
            $_SESSION['utilisateur'] = [
                'id' => $result,
                'nom' => $nom,
                'prenom' => $prenom,
                'pseudo' => $pseudo,
                'email' => $email
            ];
            // ✅ Redirection vers la racine
            header('Location: /~kcarasco/Gestion_de_collection/Index.php');
            exit;
        } else {
            $erreur = "Erreur lors de l'inscription. Veuillez réessayer.";
            include __DIR__ . '/../vue/utilisateur/Register.php';
        }
    }
    
    /**
     * Déconnexion de l'utilisateur
     */
    public function logout() {
        session_unset();
        session_destroy();
        // ✅ Redirection vers la racine
        header('Location: /~kcarasco/Gestion_de_collection/Index.php');
        exit;
    }
    
    /**
     * Profil de l'utilisateur connecté
     */
    public function profil() {
        if (!isset($_SESSION['utilisateur'])) {
            header('Location: /~kcarasco/Gestion_de_collection/Index.php?action=login');
            exit;
        }
        
        $utilisateur = $this->dao->trouverParId($_SESSION['utilisateur']['id']);
        include __DIR__ . '/../vue/utilisateur/Profil.php';
    }
}
?>




