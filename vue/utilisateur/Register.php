<?php
$pageTitle = "Inscription";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h1>Inscription</h1>

<?php if (isset($erreur)): ?>
    <p style="color: red;"><?= htmlspecialchars($erreur); ?></p>
<?php endif; ?>

<form method="POST" action="<?= url('Index.php', ['action' => 'register']) ?>">
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

    <button type="submit" class="btn">S'inscrire</button>
</form>

<p><a href="<?= url('Index.php', ['action' => 'login']) ?>">Déjà inscrit ?</a></p>
<p><a href="<?= url('Index.php') ?>">Retour à l'accueil</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>


