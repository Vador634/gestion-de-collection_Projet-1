# 📦 Gestion de Collection - PHP MVC

Système de gestion de collection (jeux, livres, films) réalisé en PHP pur suivant l'architecture **Modèle-Vue-Contrôleur (MVC)**.

## ✨ Fonctionnalités
- **CRUD Complet** : Ajouter, Visualiser, Modifier et Supprimer des éléments.
- **Architecture MVC** : Séparation stricte de la logique métier, des données et de l'affichage.
- **Base de données** : Gestion via PDO pour plus de sécurité.

## 🛠️ Installation
1. Clonez le dépôt :
   ```bash
   git clone [https://github.com/Vador634/gestion-de-collection_Projet-1.git](https://github.com/Vador634/gestion-de-collection_Projet-1.git)
Importez le fichier SQL (fourni dans /sql ou /db) dans votre base de données MySQL.

Configurez vos accès BDD dans le fichier config.php ou Database.php.

Lancez un serveur local (WAMP, MAMP, XAMPP ou PHP Built-in server).

📂 Structure du Projet
src/Controller/ : Logique de contrôle des entrées.

src/Model/ : Interaction avec la base de données.

src/View/ : Fichiers de rendu HTML.

public/ : Point d'entrée (index.php) et assets (CSS/JS).

🔒 Sécurité
Utilisation de requêtes préparées (PDO).

Protection contre les failles XSS via htmlspecialchars.
Developed by:

    Vador634

