<?php
// vue/documentation.php
// page descriptive du fonctionnement du site
?>
<?php include __DIR__ . "/partials/header.php"; ?>

<style>
    /* Styles spécifiques pour le système d'onglets de la documentation */
    .tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 10px;
    }
    .tab-btn {
        background-color: #e9ecef;
        color: #495057;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        font-size: 1rem;
        transition: background-color 0.2s, color 0.2s;
    }
    .tab-btn:hover {
        background-color: #ced4da;
    }
    .tab-btn.active {
        background-color: #0d6efd;
        color: #ffffff;
    }
    .tab-content {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }
    .tab-content.active {
        display: block;
    }
    .doc-section h3 {
        color: #0d6efd;
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 5px;
        margin-top: 2rem;
    }
    .doc-section ul, .doc-section ol {
        line-height: 1.8;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<h2>Documentation du Projet 🎮</h2>

<div class="tabs">
    <button class="tab-btn active" onclick="switchTab(event, 'user-guide')">👨‍💻 Manuel Utilisateur</button>
    <button class="tab-btn" onclick="switchTab(event, 'tech-arch')">⚙️ Architecture Technique</button>
    <button class="tab-btn" onclick="switchTab(event, 'ui-ux')">🎨 UI, Ergonomie & Accessibilité</button>
</div>

<!-- SECTION 1 : MANUEL UTILISATEUR -->
<div id="user-guide" class="tab-content active doc-section">
    <p>Ce guide vous accompagne pas à pas dans l'installation et l'utilisation de l'application de Gestion de Collection de Jeux Vidéo.</p>

    <h3>1. Installation et Premier lancement</h3>
    <ol>
        <li><strong>Prérequis :</strong> Assurez-vous de disposer d'un serveur local (XAMPP, WAMP, Laragon) incluant PHP 7.4+ et MySQL/MariaDB.</li>
        <li><strong>Base de données :</strong> Importez le fichier <code>GestionDeCollection.sql</code> dans votre SGBD (ex: phpMyAdmin). Cela crée la base, les tables et des données de référence (consoles, genres, éditeurs, développeurs, états, raretés).</li>
        <li><strong>Configuration :</strong> Si vos identifiants MySQL diffèrent de la configuration par défaut (utilisateur: <em>root</em>, mot de passe vide), modifiez le fichier <code>config/Database.php</code>.</li>
        <li><strong>Lancement :</strong> Placez le dossier du projet dans le répertoire web de votre serveur (ex: <code>htdocs</code> ou <code>www</code>) et accédez à l'URL correspondante via votre navigateur. L'URL s'adaptera automatiquement.</li>
    </ol>

    <h3>2. Création de compte et Authentification</h3>
    <ul>
        <li><strong>Inscription :</strong> Accédez à la page "Inscription" pour créer un profil. Le mot de passe sera sécurisé (haché) en base de données.</li>
        <li><strong>Connexion :</strong> Une fois le compte créé, connectez-vous pour débloquer le menu principal (Profil, Collections, Consoles, etc.).</li>
    </ul>

    <h3>3. Gérer vos collections et vos jeux</h3>
    <ul>
        <li><strong>Créer une collection :</strong> Naviguez vers l'onglet "Mes collections" et cliquez sur le bouton d'ajout. Vous pouvez y renseigner un nom et une note personnelle (ex: "Mes jeux rétro").</li>
        <li><strong>Ajouter un jeu :</strong> Depuis une collection ou l'accueil, vous pouvez renseigner un jeu avec des informations riches : année, prix estimé, et lui lier de multiples entités (consoles, genres, éditeurs).</li>
        <li><strong>Modifier un jeu :</strong> Lors du clic sur "Modifier" depuis la fiche d'un jeu, les informations pré-existantes (y compris les cases à cocher des consoles et genres) sont automatiquement pré-remplies.</li>
        <li><strong>Gestion des tables de référence :</strong> Si une console ou un genre n'apparaît pas lors de la création d'un jeu, utilisez les menus "Consoles", "Genres" ou "Éditeurs" dans la barre de navigation pour les ajouter.</li>
    </ul>
</div>

<!-- SECTION 2 : ARCHITECTURE TECHNIQUE -->
<div id="tech-arch" class="tab-content doc-section">
    <p>Cette section détaille les choix architecturaux, les patterns de conception et le schéma de base de données utilisés pour garantir la stabilité du projet.</p>

    <h3>1. Modèle MVC & Routage (Front Controller)</h3>
    <p>Le projet repose sur une architecture stricte de type <strong>M</strong>odèle-<strong>V</strong>ue-<strong>C</strong>ontrôleur, garantissant une séparation parfaite entre la logique métier et l'affichage.</p>
    <ul>
        <li><strong>Le Front Controller (index.php) :</strong> Il intercepte toutes les requêtes (ex: <code>?action=listeJeux</code>) et ne contient <strong>aucun code HTML</strong>. Une table de routes associe chaque action à son contrôleur et à ses règles d'accès : connexion obligatoire, paramètres <code>id</code> validés comme entiers, actions de suppression acceptées uniquement en POST. S'il n'y a pas d'action, il appelle le <code>HomeController</code>.</li>
        <li><strong>Les Contrôleurs (ex: JeuController) :</strong> Ils reçoivent les données du routeur, effectuent les vérifications (ex: champs de formulaire vides), demandent les données aux Modèles, et préparent un tableau de variables final avant d'inclure la Vue.</li>
        <li><strong>Les Vues (ex: /vue/jeu/Liste.php) :</strong> Elles gèrent uniquement le rendu visuel. Aucune requête SQL n'est effectuée ici. Toutes les données affichées sont échappées avec la fonction <code>e()</code> (<code>htmlspecialchars</code>).</li>
    </ul>

    <h3>2. Schéma de Base de Données & Relations</h3>
    <p>La base implémente un système relationnel fort, exploitant massivement les relations <strong>Plusieurs-à-Plusieurs (Many-to-Many)</strong> :</p>
    <ul>
        <li><strong>Tables Référentielles :</strong> <code>Genre</code>, <code>Console</code>, <code>Editeur</code>, <code>Developpeur</code>, <code>ConditionJeu</code>, <code>Rarete</code>.</li>
        <li><strong>Tables Centrales :</strong> <code>Jeu</code> et <code>Collection</code>.</li>
        <li><strong>Tables de Jonction (Associatives) :</strong> 
            <ul>
                <li><code>Disponible</code> (Jointure Jeu <-> Console)</li>
                <li><code>GenreJeu</code> (Jointure Jeu <-> Genre)</li>
                <li><code>Edite</code> (Jointure Jeu <-> Editeur)</li>
                <li><code>Appartient</code> (Jointure Jeu <-> Collection)</li>
            </ul>
        </li>
    </ul>

    <h3>3. Sécurité (PDO) et Transactions SQL</h3>
    <p>Toute la logique d'accès aux données est regroupée dans les fichiers <strong>DAO (Data Access Object)</strong>.</p>
    <ul>
        <li><strong>Requêtes Préparées :</strong> 100% des requêtes utilisent les requêtes préparées PDO (<code>bindValue</code>) ce qui rend l'application immunisée contre les injections SQL.</li>
        <li><strong>Transactions SQL :</strong> Pour les modifications complexes nécessitant de nettoyer puis de réinsérer des cases à cocher (ex: <code>JeuDAO::setConsoles</code>), nous utilisons des transactions (<code>beginTransaction()</code> et <code>commit()</code>) pour garantir la cohérence des données en cas de panne réseau.</li>
        <li><strong>Mots de passe :</strong> <code>password_hash()</code> / <code>password_verify()</code>, 8 caractères minimum, identifiant de session régénéré à la connexion.</li>
        <li><strong>Jeton CSRF :</strong> chaque formulaire contient un jeton propre à la session ; une requête POST sans jeton valide est refusée par le routeur.</li>
        <li><strong>Propriété des collections :</strong> un utilisateur ne peut consulter, modifier ou supprimer que ses propres collections.</li>
        <li><strong>Suppressions :</strong> elles passent par un bouton (formulaire POST) avec confirmation, jamais par un simple lien.</li>
    </ul>
</div>

<!-- SECTION 3 : UI, ERGONOMIE & ACCESSIBILITÉ -->
<div id="ui-ux" class="tab-content doc-section">
    <p>L'interface a été entièrement auditée et refondue pour offrir une expérience professionnelle, fluide et accessible à tous les utilisateurs.</p>

    <h3>1. Accessibilité visuelle et Contrastes (WCAG)</h3>
    <ul>
        <li><strong>Lisibilité :</strong> Abandon des polices fantaisies ou peu lisibles au profit d'une "System Font Stack" (San Francisco, Segoe UI, Roboto). Ces polices sont douces pour les yeux et s'adaptent nativement à l'OS de l'utilisateur.</li>
        <li><strong>Contrastes :</strong> Les boutons d'actions principales respectent des ratios de contraste élevés. Le bouton primaire (Bleu) contient un texte purement blanc. Le survol (<code>:hover</code>) assombrit le bouton sans jamais compromettre la visibilité du texte.</li>
    </ul>

    <h3>2. Architecture CSS (DRY & OOCSS)</h3>
    <p>Le fichier CSS a été factorisé pour éviter la répétition de code et prévenir les conflits de style :</p>
    <ul>
        <li><strong>Structure vs Apparence :</strong> La classe <code>.btn</code> définit la "structure" d'un bouton (espacement, bordures, typographie, transition). Les classes modificatrices (ex: <code>.btn-primary</code>, <code>.btn-danger</code>) n'apportent que la couleur de fond et le texte.</li>
        <li><strong>Formulaires :</strong> Les champs de saisie (inputs, selects, textareas) possèdent un effet de Focus évident (un halo bleu) permettant de savoir visuellement quel champ est actif, aidant considérablement la navigation au clavier.</li>
    </ul>

    <h3>3. Ergonomie et Navigation Contextuelle</h3>
    <ul>
        <li><strong>Navigation contextuelle :</strong> chaque page propose un bouton <code>← Retour</code> (classe <code>.btn-back</code>) vers la page logique précédente : un jeu créé depuis une collection y est ajouté directement et l'on revient à cette collection.</li>
        <li><strong>Messages de confirmation :</strong> après chaque action (ajout, modification, suppression), un message s'affiche en haut de la page suivante.</li>
        <li><strong>Catégorisation des informations :</strong> Lors de l'ajout d'un jeu, les longues listes de cases à cocher (Consoles, Genres, Éditeurs) sont englobées dans des <code>&lt;fieldset&gt;</code> avec leurs légendes claires, séparant logiquement le formulaire en petits blocs digestes.</li>
    </ul>
</div>

<script>
    /**
     * Gère le basculement entre les onglets de la documentation
     */
    function switchTab(evt, tabId) {
        // 1. Cacher tous les contenus
        const contents = document.querySelectorAll('.tab-content');
        contents.forEach(content => content.classList.remove('active'));
        
        // 2. Retirer l'état "actif" de tous les boutons
        const buttons = document.querySelectorAll('.tab-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        
        // 3. Afficher le contenu cliqué et rendre son bouton actif
        document.getElementById(tabId).classList.add('active');
        evt.currentTarget.classList.add('active');
    }
</script>

<?php include __DIR__ . "/partials/footer.php"; ?>
