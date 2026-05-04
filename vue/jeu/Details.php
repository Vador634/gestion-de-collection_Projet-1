<?php
/** @var Jeu $jeu */
/** @var Console[] $consoles */
/** @var Genre[] $genres */
/** @var Editeur[] $editeurs */

$pageTitle = "Détails du jeu";
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Détails du Jeu</h2>
<?php if ($jeu): ?>
    <p><strong>Titre :</strong> <?= htmlspecialchars($jeu->getTitre()) ?></p>
    <p><strong>Année de sortie :</strong> <?= htmlspecialchars($jeu->getAnneeSortie()) ?></p>
    <p><strong>Prix estimé :</strong> <?= htmlspecialchars($jeu->getPrixEstime()) ?> €</p>
    <?php if ($jeu->getIdCondition()): ?>
        <p><strong>Condition (id) :</strong> <?= htmlspecialchars((string)$jeu->getIdCondition()) ?></p>
    <?php endif; ?>
    <?php if ($jeu->getIdRarete()): ?>
        <p><strong>Rareté (id) :</strong> <?= htmlspecialchars((string)$jeu->getIdRarete()) ?></p>
    <?php endif; ?>
    <?php if ($jeu->getIdDeveloppeur()): ?>
        <p><strong>Développeur (id) :</strong> <?= htmlspecialchars((string)$jeu->getIdDeveloppeur()) ?></p>
    <?php endif; ?>

    <?php if (!empty($consoles)): ?>
        <p><strong>Consoles :</strong> <?= implode(', ', array_map(fn(Console $c)=>htmlspecialchars($c->getNomConsole()), $consoles)) ?></p>
    <?php endif; ?>
    <?php if (!empty($genres)): ?>
        <p><strong>Genres :</strong> <?= implode(', ', array_map(fn(Genre $g)=>htmlspecialchars($g->getNomGenre()), $genres)) ?></p>
    <?php endif; ?>
    <?php if (!empty($editeurs)): ?>
        <p><strong>Éditeurs :</strong> <?= implode(', ', array_map(fn(Editeur $e)=>htmlspecialchars($e->libelleEditeur), $editeurs)) ?></p>
    <?php endif; ?>
<?php else: ?>
    <p>Jeu introuvable.</p>
<?php endif; ?>
<a href="javascript:history.back()" class="btn btn-back">← Retour</a>

<?php include __DIR__ . "/../partials/footer.php"; ?>
