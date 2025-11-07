<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    
    <?php if (isset($erreur)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($erreur); ?></p>
    <?php endif; ?>
    
    <!-- ✅ Action vers Index.php à la racine -->
    <form method="POST" action="/~kcarasco/Gestion_de_collection/Index.php?action=login">
        <label>Email :</label>
        <input type="email" name="email" required><br><br>
        
        <label>Mot de passe :</label>
        <input type="password" name="motDePasse" required><br><br>
        
        <button type="submit">Se connecter</button>
    </form>
    
    <p><a href="/~kcarasco/Gestion_de_collection/Index.php?action=register">Pas encore inscrit ?</a></p>
    <p><a href="/~kcarasco/Gestion_de_collection/Index.php">Retour à l'accueil</a></p>
</body>
</html>