<?php
// vue/collection/creer.php
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Créer une collection</h2>

<?php if (!empty($error)): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post" action="">
    <label>Nom de la collection :</label><br>
    <input type="text" name="nomCollection" required><br><br>

    <label>Etat :</label><br>
    <input type="text" name="etat"><br><br>

    <label>Note personnelle :</label><br>
    <textarea name="notePerso"></textarea><br><br>

    <label>Id utilisateur (owner) :</label><br>
    <input type="number" name="idUtilisateur" value="1" required><br><br>

    <button type="submit">Créer</button>
</form>

<?php include __DIR__ . "/../partials/footer.php"; ?>

