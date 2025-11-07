<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    
    <?php if (isset($erreur)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($erreur); ?></p>
    <?php endif; ?>
    
    <!-- ✅ Action vers Index.php à la racine -->
    <form method="POST" action="/~kcarasco/Gestion_de_collection/Index.php?action=register">
        <label>Nom :</label>
        <input type="text" name="nom" required><br><br>
        
        <label>Prénom :</label>
        <input type="text" name="prenom" required><br><br>
        
        <label>Pseudo :</label>
        <input type="text" name="pseudo" required><br><br>
        
        <label>Email :</label>
        <input type="email" name="email" required><br><br>
        
        <label>Mot de passe :</label>
        <input type="password" name="motDePasse" required><br><br>
        
        <button type="submit">S'inscrire</button>
    </form>
    
    <p><a href="/~kcarasco/Gestion_de_collection/Index.php?action=login">Déjà inscrit ?</a></p>
    <p><a href="/~kcarasco/Gestion_de_collection/Index.php">Retour à l'accueil</a></p>
</body>
</html>


