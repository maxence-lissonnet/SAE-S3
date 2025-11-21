<?php
// Vue/ajoucom.php

require_once __DIR__ . '/../Controller/contrajouecom.php';

$formErrors = $formErrors ?? [];
$formData   = $formData   ?? [];
$typesCom   = $typesCom   ?? [];
$roles      = $roles      ?? [];
$editId     = $editId     ?? null;     // id de la com si on est en mode édition
?>
<link rel="stylesheet" href="../Asset/style/ajouecomstyle.css">
<?php require __DIR__ . '/header.php'; ?>

<main class="eg-ajout-page">
  <a href="pagecom.php" class="eg-back-link">
    ← Retour aux communications
  </a>

  <h1 class="eg-ajout-title">
    <?= $editId ? 'Modification publication' : 'Création publication' ?>
  </h1>

  <?php if (!empty($formErrors)): ?>
    <ul class="eg-form-errors">
      <?php foreach ($formErrors as $err): ?>
        <li><?= htmlspecialchars($err) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <!-- Formulaire PRINCIPAL : création / mise à jour -->
  <!-- IMPORTANT : on ajoute l'id="publishForm" -->
  <form method="post" class="eg-ajout-form" id="publishForm">

    <?php if ($editId): ?>
      <input type="hidden" name="idCom" value="<?= (int)$editId ?>">
    <?php endif; ?>

    <section class="eg-ajout-layout">

      <!-- COLONNE GAUCHE : champs texte -->
      <section class="eg-ajout-left">

        <label class="eg-field-group">
          <span>Titre publication*</span>
          <input type="text" name="titreCom"
                 value="<?= htmlspecialchars($formData['titreCom'] ?? '') ?>">
        </label>

        <label class="eg-field-group">
          <span>Catégorie publication*</span>
          <select name="idTypeCom">
            <option value="">-- choisir --</option>
            <?php foreach ($typesCom as $type): ?>
              <option value="<?= $type['idTypeCom'] ?>"
                <?= (!empty($formData['idTypeCom']) &&
                     (int)$formData['idTypeCom'] === (int)$type['idTypeCom']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($type['nomTypeCom']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </label>

        <label class="eg-field-group">
          <span>Description*</span>
          <textarea name="contenuCom" rows="8"><?= htmlspecialchars($formData['contenuCom'] ?? '') ?></textarea>
        </label>

      </section>

      <!-- COLONNE DROITE : Illustration + destination + publier -->
      <aside class="eg-ajout-right">

        <!-- Illustration via URL -->
        <div class="eg-ajout-illu-block">
          <span class="eg-ajout-label">Illustration publication</span>

          <button type="button" class="eg-btn-illu-disabled" disabled>
            IMPORTER VIA ORDINATEUR
          </button>

          <label class="eg-btn-illu-url" for="imageUrl">
            IMPORTER VIA URL
          </label>

          <input
            type="url"
            id="imageUrl"
            name="imageUrl"
            class="eg-input-url"
            placeholder="https://exemple.com/image.jpg"
            value="<?= htmlspecialchars($formData['imageUrl'] ?? '') ?>"
          >

          <?php if (!empty($formData['imageUrl'])): ?>
            <div class="eg-ajout-url-preview">
              <?= htmlspecialchars($formData['imageUrl']) ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- Destination : rôles -->
        <div class="eg-ajout-destination">
          <span class="eg-ajout-dest-label">Destination</span>

          <div class="eg-roles-list">
            <?php foreach ($roles as $role): ?>
              <?php
              $checked = !empty($formData['roles'])
                         && in_array((int)$role['idRole'], $formData['roles'], true);
              ?>
              <label class="eg-role-pill">
                <input type="checkbox"
                       name="roles[]"
                       value="<?= $role['idRole'] ?>"
                       <?= $checked ? 'checked' : '' ?>>
                <span><?= htmlspecialchars($role['nomRole']) ?></span>
              </label>
            <?php endforeach; ?>
          </div>

          <p class="eg-ajout-dest-help">
            Si aucun rôle n'est sélectionné, la publication sera considérée comme destinée à tous les rôles.
          </p>
        </div>

        <!-- BOUTON PUBLIER / METTRE À JOUR -->
        <div class="eg-ajout-publish">
          <!-- type="button" pour laisser JS gérer la soumission -->
          <button type="button"
                  id="publishButton"
                  class="eg-btn-main">
            <?= $editId ? 'Mettre à jour' : 'Publier' ?>
          </button>
        </div>

      </aside>

    </section>

  </form>

</main>

<?php require __DIR__ . '/footer.php'; ?>

</body>
</html>
