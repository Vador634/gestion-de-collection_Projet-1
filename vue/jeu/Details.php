<?php
$pageTitle = "Détails du jeu";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Détails du Jeu</h2>
<?php if ($jeu): ?>
    <p><strong>Titre :</strong> <?= htmlspecialchars($jeu->getTitre()) ?></p>
    <p><strong>Année de sortie :</strong> <?= htmlspecialchars($jeu->getAnneeSortie()) ?></p>
    <p><strong>Prix estimé :</strong> <?= htmlspecialchars($jeu->getPrixEstime()) ?> €</p>
    <?php if ($jeu->getIdCondition()): ?>
        <p><strong>Condition (id) :</strong> <?= htmlspecialchars($jeu->getIdCondition()) ?></p>
    <?php endif; ?>
    <?php if ($jeu->getIdRarete()): ?>
        <p><strong>Rareté (id) :</strong> <?= htmlspecialchars($jeu->getIdRarete()) ?></p>
    <?php endif; ?>
    <?php if ($jeu->getIdDeveloppeur()): ?>
        <p><strong>Développeur (id) :</strong> <?= htmlspecialchars($jeu->getIdDeveloppeur()) ?></p>
    <?php endif; ?>

    <?php if (!empty($consoles)): ?>
        <p><strong>Consoles :</strong> <?= implode(', ', array_map(fn($c)=>htmlspecialchars($c->getNomConsole()), $consoles)) ?></p>
    <?php endif; ?>
    <?php if (!empty($genres)): ?>
        <p><strong>Genres :</strong> <?= implode(', ', array_map(fn($g)=>htmlspecialchars($g->getNomGenre()), $genres)) ?></p>
    <?php endif; ?>
    <?php if (!empty($editeurs)): ?>
        <p><strong>Éditeurs :</strong> <?= implode(', ', array_map(fn($e)=>htmlspecialchars($e->libelleEditeur), $editeurs)) ?></p>
    <?php endif; ?>
<?php else: ?>
    <p>Jeu introuvable.</p>
<?php endif; ?>
<a href="<?= url('Index.php', ['action' => 'listeJeux']) ?>">Retour à la liste</a>

<?php include __DIR__ . "/../partials/footer.php"; ?>
