<?php
/** @var Collection $collection */
/** @var int $nbJeux */
/** @var float $valeurTotale */
/** @var Jeu[] $jeux */
/** @var Jeu[] $jeuxDisponibles jeux du catalogue absents de la collection */
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<p>
    Créée le <?= e(date('d/m/Y', strtotime($collection->dateCreation))) ?> ·
    <strong><?= $nbJeux ?></strong> jeu(x) ·
    valeur estimée <strong><?= e(number_format($valeurTotale, 2, ',', ' ')) ?> €</strong>
</p>
<?php if ($collection->notePerso !== null && $collection->notePerso !== ''): ?>
    <blockquote><?= nl2br(e($collection->notePerso)) ?></blockquote>
<?php endif; ?>

<p class="actions">
    <a href="<?= e(url('index.php', ['action' => 'modifierCollection', 'id' => $collection->idCollection])) ?>" class="btn btn-secondary btn-sm">Modifier la collection</a>
    <?php
        $supprAction = 'supprimerCollection';
        $supprParams = ['id' => $collection->idCollection];
        $supprLibelle = 'Supprimer la collection';
        $supprConfirmation = "Supprimer la collection « {$collection->nomCollection} » ? Les jeux restent dans le catalogue.";
        include __DIR__ . "/../partials/bouton_supprimer.php";
    ?>
</p>

<h2>Jeux de la collection</h2>
<?php if (empty($jeux)): ?>
    <p>Aucun jeu pour le moment.</p>
<?php else: ?>
    <table>
        <thead><tr><th>Titre</th><th>Année</th><th>Prix estimé</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($jeux as $jeu): ?>
            <tr>
                <td><a href="<?= e(url('index.php', ['action' => 'detailsJeu', 'id' => $jeu->getIdJeu()])) ?>"><?= e($jeu->getTitre()) ?></a></td>
                <td><?= e($jeu->getAnneeSortie() ?: '—') ?></td>
                <td><?= $jeu->getPrixEstime() !== null ? e(number_format((float)$jeu->getPrixEstime(), 2, ',', ' ')) . ' €' : '—' ?></td>
                <td class="actions">
                    <?php
                        $supprAction = 'retirerJeuCollection';
                        $supprParams = ['id' => $collection->idCollection, 'idJeu' => $jeu->getIdJeu()];
                        $supprLibelle = 'Retirer';
                        $supprClasse = 'btn-secondary';
                        $supprConfirmation = "Retirer « {$jeu->getTitre()} » de la collection ?";
                        include __DIR__ . "/../partials/bouton_supprimer.php";
                        unset($supprClasse);
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<h2>Ajouter un jeu</h2>
<?php if (!empty($jeuxDisponibles)): ?>
    <form method="post" action="<?= e(url('index.php', ['action' => 'ajouterJeuCollection', 'id' => $collection->idCollection])) ?>">
        <?= csrf_field() ?>
        <label for="idJeu">Jeu du catalogue</label>
        <select name="idJeu" id="idJeu" required>
            <option value="">-- Sélectionner --</option>
            <?php foreach ($jeuxDisponibles as $j): ?>
                <option value="<?= (int)$j->getIdJeu() ?>"><?= e($j->getTitre()) ?><?= $j->getAnneeSortie() ? ' (' . e($j->getAnneeSortie()) . ')' : '' ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary">Ajouter à la collection</button>
    </form>
<?php else: ?>
    <p>Tous les jeux du catalogue sont déjà dans cette collection.</p>
<?php endif; ?>

<p>ou <a href="<?= e(url('index.php', ['action' => 'ajouterJeu', 'idCollection' => $collection->idCollection])) ?>">créer un nouveau jeu et l'ajouter directement</a>.</p>

<p><a href="<?= e(url('index.php', ['action' => 'listeCollections'])) ?>" class="btn btn-back">← Mes collections</a></p>

<?php include __DIR__ . "/../partials/footer.php"; ?>
