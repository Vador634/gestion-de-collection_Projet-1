<?php
/**
 * Bouton de suppression : un petit formulaire POST avec jeton CSRF et
 * confirmation (une suppression ne passe jamais par un simple lien).
 *
 * Variables attendues : $supprAction, $supprParams (array), $supprLibelle,
 * $supprConfirmation, et facultativement $supprClasse.
 */
?>
<form method="post" class="inline-form" action="<?= e(url('index.php', ['action' => $supprAction] + $supprParams)) ?>"
      onsubmit="return confirm(<?= e(json_encode($supprConfirmation, JSON_UNESCAPED_UNICODE)) ?>)">
    <?= csrf_field() ?>
    <button type="submit" class="btn <?= e($supprClasse ?? 'btn-danger') ?> btn-sm"><?= e($supprLibelle) ?></button>
</form>
