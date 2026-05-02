<?php
$pageTitle = "Connexion";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h1>Connexion</h1>

<?php if (isset($erreur)): ?>
    <p style="color: red;"><?= htmlspecialchars($erreur); ?></p>
<?php endif; ?>

<form method="POST" action="<?= url('Index.php', ['action' => 'login']) ?>">
    <label>Email :</label>
    <input type="email" name="email" required><br><br>

    <label>Mot de passe :</label>
    <input type="password" name="motDePasse" required><br><br>

    <button type="submit" class="btn">Se connecter</button>
</form>

<p><a href="<?= url('Index.php', ['action' => 'register']) ?>">Pas encore inscrit ?</a></p>
<p><a href="<?= url('Index.php') ?>">Retour à l'accueil</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>