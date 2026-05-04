<?php
/** @var Jeu $jeu */
/** @var Condition[] $conditions */
/** @var Rarete[] $raretes */
/** @var Developpeur[] $developpeurs */
/** @var Console[] $consoles */
/** @var Genre[] $genres */
/** @var Editeur[] $editeurs */
/** @var Console[] $currentConsoles */
/** @var Genre[] $currentGenres */
/** @var Editeur[] $currentEditeurs */
/** @var string|null $erreur */
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<h2>Modifier un Jeu</h2>

<?php if (!empty($erreur)): ?>
    <p style="color:red"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<?php
// Préparation des tableaux d'ID pour pré-cocher les cases
$currentConsoleIds = array_map(fn($c) => $c->getIdConsole(), $currentConsoles ?? []);
$currentGenreIds = array_map(fn($g) => $g->getIdGenre(), $currentGenres ?? []);
$currentEditeurIds = array_map(fn($e) => $e->idEditeur, $currentEditeurs ?? []);
?>
<?php if ($jeu): ?>
<form method="post" action="<?= url('Index.php', ['action' => 'modifierJeu', 'id' => $jeu->getIdJeu()]) ?>">
    <label>Titre :</label><br>
    <input type="text" name="titre" value="<?= htmlspecialchars($jeu->getTitre()) ?>" required><br><br>

    <label>Année de sortie :</label><br>
    <input type="number" name="anneeSortie" value="<?= htmlspecialchars((string)$jeu->getAnneeSortie()) ?>" required><br><br>

    <label>Prix estimé :</label><br>
    <input type="number" step="0.01" name="prixEstime" value="<?= htmlspecialchars($jeu->getPrixEstime()) ?>" required><br><br>

    <label>Condition :</label><br>
    <select name="idCondition">
        <option value="">-- Sélectionner --</option>
        <?php foreach ($conditions as $c): ?>
            <option value="<?= $c->idCondition ?>" <?= $jeu->getIdCondition() == $c->idCondition ? 'selected' : '' ?>><?= htmlspecialchars($c->libelleCondition) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Rareté :</label><br>
    <select name="idRarete">
        <option value="">-- Sélectionner --</option>
        <?php foreach ($raretes as $r): ?>
            <option value="<?= $r->idRarete ?>" <?= $jeu->getIdRarete() == $r->idRarete ? 'selected' : '' ?>><?= htmlspecialchars($r->libelleRarete) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Développeur :</label><br>
    <select name="idDeveloppeur">
        <option value="">-- Sélectionner --</option>
        <?php foreach ($developpeurs as $d): ?>
            <option value="<?= $d->idDeveloppeur ?>" <?= $jeu->getIdDeveloppeur() == $d->idDeveloppeur ? 'selected' : '' ?>><?= htmlspecialchars($d->libelleDeveloppeur) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <fieldset style="border: 1px solid #ced4da; border-radius: 4px; padding: 1rem; margin-bottom: 1rem;">
        <legend style="padding: 0 0.5rem; font-weight: 600;">Consoles associées</legend>
        <?php foreach ($consoles as $c): ?>
            <label style="display:inline-block; margin-right: 15px; margin-top: 0;"><input type="checkbox" name="consoles[]" value="<?= $c->getIdConsole() ?>" <?= in_array($c->getIdConsole(), $currentConsoleIds) ? 'checked' : '' ?>> <?= htmlspecialchars($c->getNomConsole()) ?></label>
        <?php endforeach; ?>
    </fieldset>

    <fieldset style="border: 1px solid #ced4da; border-radius: 4px; padding: 1rem; margin-bottom: 1rem;">
        <legend style="padding: 0 0.5rem; font-weight: 600;">Genres associés</legend>
        <?php foreach ($genres as $g): ?>
            <label style="display:inline-block; margin-right: 15px; margin-top: 0;"><input type="checkbox" name="genres[]" value="<?= $g->getIdGenre() ?>" <?= in_array($g->getIdGenre(), $currentGenreIds) ? 'checked' : '' ?>> <?= htmlspecialchars($g->getNomGenre()) ?></label>
        <?php endforeach; ?>
    </fieldset>

    <fieldset style="border: 1px solid #ced4da; border-radius: 4px; padding: 1rem; margin-bottom: 1rem;">
        <legend style="padding: 0 0.5rem; font-weight: 600;">Éditeurs associés</legend>
        <?php foreach ($editeurs as $e): ?>
            <label style="display:inline-block; margin-right: 15px; margin-top: 0;"><input type="checkbox" name="editeurs[]" value="<?= $e->idEditeur ?>" <?= in_array($e->idEditeur, $currentEditeurIds) ? 'checked' : '' ?>> <?= htmlspecialchars($e->libelleEditeur) ?></label>
        <?php endforeach; ?>
    </fieldset>

    <button type="submit" class="btn btn-primary">Modifier</button>
</form>
<?php else: ?>
    <p>Jeu introuvable.</p>
<?php endif; ?>

<a href="javascript:history.back()" class="btn btn-back">← Retour</a>

<?php include __DIR__ . "/../partials/footer.php"; ?>
