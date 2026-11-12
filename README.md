# Gestion de Collection — PHP MVC

Application web de **gestion de collections de jeux vidéo** développée en **PHP 8 orienté objet**, sans framework, avec une architecture **MVC + DAO** et une base **MySQL / MariaDB**.

Chaque utilisateur crée ses collections, y range des jeux d'un catalogue commun et suit leur état, leur rareté et leur valeur estimée.

> Projet n°1 du BTS SIO option SLAM — application web MVC objet avec base de données.

<img width="1350" height="638" alt="Accueil de l'application" src="https://github.com/user-attachments/assets/0f63bb4c-f648-4711-aca1-4e96e16206d6" />

---

## Fonctionnalités

- **Comptes utilisateurs** : inscription, connexion, profil, déconnexion.
- **Collections personnelles** : création, modification, suppression, nombre de jeux et valeur totale estimée.
- **Catalogue de jeux** : titre, année, prix estimé, état, rareté, développeur, plusieurs consoles, genres et éditeurs.
- **Ajout rapide** : un jeu créé depuis une collection y est ajouté directement.
- **Référentiels** : gestion des consoles, genres et éditeurs (CRUD complet).
- **Documentation intégrée** : manuel utilisateur et architecture technique, consultables dans l'application.

## Architecture

```
index.php                 Routeur (front controller) : table des actions et règles d'accès
config/
├── Database.php          Connexion PDO unique (identifiants surchargeables par variables d'environnement)
└── autoload.php          Chargement des classes, URL de base, fonctions utilitaires (échappement, CSRF, redirections)
controleur/               Un contrôleur par entité : Collection, Jeu, Console, Genre, Editeur, Utilisateur...
modele/                   Classes métier (Jeu, Collection...) et DAO (requêtes SQL)
vue/                      Pages HTML par entité + partials (en-tête, pied de page, bouton de suppression)
assets/style.css          Feuille de style
GestionDeCollection.sql   Création de la base, des tables et des données de démonstration
Documentation/            Sujet, grille d'évaluation, MCD, MLD et documentation MVC
```

Le cycle d'une requête : `index.php?action=detailsJeu&id=3` → le routeur vérifie la connexion et l'identifiant → `JeuController::details(3)` interroge `JeuDAO` → la vue `vue/jeu/Details.php` affiche le résultat.

## Sécurité

| Risque | Protection |
|---|---|
| Injection SQL | Requêtes préparées PDO uniquement |
| XSS | Toutes les sorties passent par `e()` (`htmlspecialchars`) |
| CSRF | Jeton de session dans chaque formulaire, vérifié par le routeur pour toute requête POST |
| Accès aux données des autres | Un utilisateur ne voit et ne modifie que ses propres collections (403 sinon) |
| Suppressions accidentelles | Uniquement en POST, depuis un bouton avec confirmation |
| Mots de passe | `password_hash` / `password_verify`, 8 caractères minimum, session régénérée à la connexion |
| Cohérence des données | Transactions pour les associations et les suppressions en cascade |

## Installation

**Prérequis** : PHP 7.4 ou plus et MySQL / MariaDB (XAMPP, WAMP ou Laragon conviennent).

1. Cloner le dépôt dans le dossier web du serveur (`htdocs/` ou `www/`) :
   ```bash
   git clone https://github.com/Vador634/gestion-de-collection_Projet-1.git
   ```
2. Importer `GestionDeCollection.sql` dans phpMyAdmin (ou `mysql -u root < GestionDeCollection.sql`).
   Le script crée la base `gestion_de_collection`, les tables, les listes de référence et quelques jeux d'exemple.
3. Adapter si besoin les identifiants dans `config/Database.php` (par défaut `root` sans mot de passe).
4. Ouvrir `http://localhost/gestion-de-collection_Projet-1/` et créer un compte.

Le projet fonctionne aussi bien sous Windows que sur un hébergement Linux (noms de fichiers sensibles à la casse).

## Modèle de données

Tables principales : `Utilisateur`, `Collection`, `Jeu`.
Référentiels : `Console`, `Genre`, `Editeur`, `Developpeur`, `ConditionJeu`, `Rarete`.
Tables d'association : `Appartient` (collection ↔ jeu, avec date d'ajout), `Disponible` (jeu ↔ console), `GenreJeu`, `Edite`.

Le MCD et le MLD sont disponibles dans le dossier `Documentation/`.

<img width="1342" height="541" alt="Liste des collections" src="https://github.com/user-attachments/assets/588a6268-68be-4a00-a027-8f435454e4ef" />
<br>
<img width="939" height="617" alt="Fiche d'un jeu" src="https://github.com/user-attachments/assets/440d5b07-c951-4af4-a78c-e29061396070" />

## Auteur

**Kilian Carasco** — étudiant en Bachelor Concepteur Développeur d'Applications (EPSI Bordeaux)
[Portfolio](https://kiliandev.netlify.app) · [GitHub](https://github.com/Vador634) · [LinkedIn](https://www.linkedin.com/in/kilian-carasco-029915399/)
