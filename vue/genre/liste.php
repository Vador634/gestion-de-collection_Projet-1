<?php include("vue/partials/header.php"); ?>
<h1>Liste des Genres</h1>

<ul>
    <?php foreach ($genres as $g): ?>
        <li>
            <a href="index.php?action=detailsGenre&id=<?php echo $g->getIdGenre(); ?>">
                <?php echo htmlspecialchars($g->getNomGenre()); ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<h2>Ajouter un genre</h2>
<form method="POST" action="index.php?action=ajouterGenre">
    Nom du genre : <input type="text" name="nomGenre" required><br>
    <input type="submit" value="Ajouter">
</form>
<?php include("vue/partials/footer.php"); ?>

