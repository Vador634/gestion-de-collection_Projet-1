<?php
/**
 * Formulaire commun à l'ajout et à la modification d'un jeu.
 *
 * @var array  $valeurs  titre, anneeSortie, prixEstime, idCondition, idRarete,
 *                       idDeveloppeur, consoles[], genres[], editeurs[]
 * @var string $actionFormulaire URL d'envoi
 * @var string $libelleBouton
 * @var Condition[] $conditions  @var Rarete[] $raretes  @var Developpeur[] $developpeurs
 * @var Console[] $consoles      @var Genre[] $genres    @var Editeur[] $editeurs
 */
$coche = function ($liste, $id) {
    return in_array((int)$id, array_map('intval', $liste)) ? ' checked' : '';
};
$selection = function ($valeur, $id) {
    return (int)$valeur === (int)$id ? ' selected' : '';
};
?>
<?php if (!empty($erreur)): ?>
    <p class="alert alert-error"><?= e($erreur) ?></p>
<?php endif; ?>

<form method="post" action="<?= e($actionFormulaire) ?>">
    <?= csrf_field() ?>
    <?php if (!empty($idCollection)): ?>
        <input type="hidden" name="idCollection" value="<?= (int)$idCollection ?>">
    <?php endif; ?>

    <label for="titre">Titre</label>
    <input type="text" id="titre" name="titre" maxlength="150" value="<?= e($valeurs['titre']) ?>" required>

    <label for="anneeSortie">Année de sortie</label>
    <input type="number" id="anneeSortie" name="anneeSortie" min="1901" max="2155" placeholder="ex : 1998" value="<?= e($valeurs['anneeSortie']) ?>">

    <label for="prixEstime">Prix estimé (€)</label>
    <input type="number" id="prixEstime" name="prixEstime" min="0" step="0.01" value="<?= e($valeurs['prixEstime']) ?>">

    <label for="idCondition">État</label>
    <select id="idCondition" name="idCondition">
        <option value="">-- Non renseigné --</option>
        <?php foreach ($conditions as $c): ?>
            <option value="<?= (int)$c->idCondition ?>"<?= $selection($valeurs['idCondition'], $c->idCondition) ?>><?= e($c->libelleCondition) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="idRarete">Rareté</label>
    <select id="idRarete" name="idRarete">
        <option value="">-- Non renseignée --</option>
        <?php foreach ($raretes as $r): ?>
            <option value="<?= (int)$r->idRarete ?>"<?= $selection($valeurs['idRarete'], $r->idRarete) ?>><?= e($r->libelleRarete) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="idDeveloppeur">Développeur</label>
    <select id="idDeveloppeur" name="idDeveloppeur">
        <option value="">-- Non renseigné --</option>
        <?php foreach ($developpeurs as $d): ?>
            <option value="<?= (int)$d->idDeveloppeur ?>"<?= $selection($valeurs['idDeveloppeur'], $d->idDeveloppeur) ?>><?= e($d->libelleDeveloppeur) ?></option>
        <?php endforeach; ?>
    </select>

    <fieldset class="choix">
        <legend>Consoles</legend>
        <?php foreach ($consoles as $c): ?>
            <label><input type="checkbox" name="consoles[]" value="<?= (int)$c->getIdConsole() ?>"<?= $coche($valeurs['consoles'], $c->getIdConsole()) ?>> <?= e($c->getNomConsole()) ?></label>
        <?php endforeach; ?>
        <?php if (!$consoles): ?><small>Aucune console : <a href="<?= e(url('index.php', ['action' => 'ajouterConsole'])) ?>">en ajouter une</a>.</small><?php endif; ?>
    </fieldset>

    <fieldset class="choix">
        <legend>Genres</legend>
        <?php foreach ($genres as $g): ?>
            <label><input type="checkbox" name="genres[]" value="<?= (int)$g->getIdGenre() ?>"<?= $coche($valeurs['genres'], $g->getIdGenre()) ?>> <?= e($g->getNomGenre()) ?></label>
        <?php endforeach; ?>
        <?php if (!$genres): ?><small>Aucun genre : <a href="<?= e(url('index.php', ['action' => 'ajouterGenre'])) ?>">en ajouter un</a>.</small><?php endif; ?>
    </fieldset>

    <fieldset class="choix">
        <legend>Éditeurs</legend>
        <?php foreach ($editeurs as $ed): ?>
            <label><input type="checkbox" name="editeurs[]" value="<?= (int)$ed->idEditeur ?>"<?= $coche($valeurs['editeurs'], $ed->idEditeur) ?>> <?= e($ed->libelleEditeur) ?></label>
        <?php endforeach; ?>
        <?php if (!$editeurs): ?><small>Aucun éditeur : <a href="<?= e(url('index.php', ['action' => 'ajouterEditeur'])) ?>">en ajouter un</a>.</small><?php endif; ?>
    </fieldset>

    <button type="submit" class="btn btn-primary"><?= e($libelleBouton) ?></button>
</form>
