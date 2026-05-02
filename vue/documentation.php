<?php
// vue/documentation.php
// page descriptive du fonctionnement du site
?>
<?php include __DIR__ . "/partials/header.php"; ?>

<h2>Documentation - Gestion des collections</h2>

<p>Cette application permet de gérer une <strong>collection de jeux vidéo</strong> classés par 
utilisateur. Les entités principales sont :</p>
<ul>
    <li><strong>Collection</strong> (nom, date de création, note personnelle, propriétaire)</li>
    <li><strong>Jeu</strong> (titre, année, prix estimé, condition, rareté, développeur, consoles, genres, éditeurs...)</li>
    <li><strong>Console</strong> (nom, fabricant)</li>
    <li><strong>Genre</strong>, <strong>Éditeur</strong>, etc. (listes de référence)</li>
</ul>

<h3>Utilisation</h3>
<ol>
    <li>Se connecter ou s'inscrire (adresse mail + mot de passe).</li>
    <li>Créer une collection via le menu &laquo; Collections &raquo;.</li>
    <li>Dans le détail d'une collection, ajouter des jeux existants ou en créer de nouveaux,
        choisir leur condition, rareté, développeur, cocher les consoles, genres et éditeurs associés.</li>
    <li>Gérer les consoles, genres et éditeurs depuis les menus dédiés pour qu'ils apparaissent dans
        les formulaires de jeux.</li>
    <li>Consulter/modifier/supprimer les éléments via les pages de détail.</li>
</ol>

<h3>Architecture</h3>
<p>Le code suit un pattern simple <em>modèle-vue-contrôleur</em> :</p>
<ul>
    <li><code>modele/</code> contient les classes métier (Jeu, Collection, etc.) et DAO pour l'accès
        à la base de données.</li>
    <li><code>controleur/</code> regroupe les contrôleurs qui récupèrent les données et incluent
        les vues.</li>
    <li><code>vue/</code> contient les scripts PHP affichant le HTML. Des partials
        <code>header.php</code> et <code>footer.php</code> sont réutilisés pour uniformiser la mise
        en page.</li>
    <li><code>Index.php</code> sert de routeur central, en déléguant l'action demandée au bon
        contrôleur.</li>
</ul>

<h3>Données</h3>
<p>Le schéma relationnel du fichier <code>GestionDeCollection.sql</code> définit les tables et
leurs clés. Les tables associatives (<code>Appartient</code>, <code>Disponible</code>,
<code>GenreJeu</code>, <code>Edite</code>) implémentent les relations plusieurs-à-plusieurs.
Certaines tables standards (condition, rareté) sont automatiquement remplies au premier accès.</p>

<h3>Style</h3>
<p>Un fichier CSS <code>assets/style.css</code> applique un thème sombre "geek" et rend le site
responsive. Les boutons utilisent la classe <code>btn</code>.</p>

<p>Pour aller plus loin, vous pouvez ajouter d'autres entités (langues, modes de jeu, etc.),
implémenter l'export/ import ou une API REST.</p>

<?php include __DIR__ . "/partials/footer.php"; ?>
