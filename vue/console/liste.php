<!DOCTYPE html>
<?php include("vue/partials/header.php"); ?>
<h1>Liste des Consoles</h1>

<ul>
    <?php foreach ($consoles as $c): ?>
        <li>
            <a href="index.php?action=detailsConsole&id=<?php echo $c->getIdConsole(); ?>">
                <?php echo htmlspecialchars($c->getNomConsole()); ?>
            </a>
            (<?php echo htmlspecialchars($c->getConstructeur()); ?>)
        </li>
    <?php endforeach; ?>
</ul>

<h2>Ajouter une console</h2>
<form method="POST" action="index.php?action=ajouterConsole">
    Nom de la console : <input type="text" name="nomConsole" required><br>
    Constructeur : <input type="text" name="constructeur" required><br>
    <input type="submit" value="Ajouter">
</form>
<?php include("vue/partials/footer.php"); ?>


