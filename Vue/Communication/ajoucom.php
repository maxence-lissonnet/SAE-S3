<?php
/* VERSION: AJOUCOM 2026-01-05 20:05 */

$formErrors = $formErrors ?? [];
$formData   = $formData   ?? [];
$typesCom   = $typesCom   ?? [];
$roles      = $roles      ?? [];
$editId     = $editId     ?? null;
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $editId ? 'Modifier publication' : 'Créer publication' ?></title>

  <link rel="stylesheet" href="Asset/style/ajouecomstyle.css">
</head>

<body>
<?php require __DIR__ . '/../../Controller/Autre/HeaderController.php'; ?>

<main class="eg-ajout-page">

  <a href="?page=Communication" class="eg-back-link">← Retour aux communications</a>

  <h1 class="eg-ajout-title">
    <?= $editId ? 'Modification publication' : 'Création publication' ?>
  </h1>

  <!-- DEBUG: si tu vois ce commentaire dans DevTools => c'est bien CE fichier qui est rendu -->
  <!-- VERSION: AJOUCOM 2026-01-05 20:05 -->

  <?php if (!empty($formErrors)): ?>
    <ul class="eg-form-errors">
      <?php foreach ($formErrors as $err): ?>
        <li><?= htmlspecialchars($err) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form method="post" class="eg-ajout-form" id="publishForm">

    <?php if ($editId): ?>
      <input type="hidden" name="idCom" value="<?= (int)$editId ?>">
    <?php endif; ?>

    <section class="eg-ajout-layout">

      <section class="eg-ajout-left">

        <label class="eg-field-group">
          <span>Titre publication*</span>
          <input type="text" name="titreCom" value="<?= htmlspecialchars($formData['titreCom'] ?? '') ?>">
        </label>

        <label class="eg-field-group">
          <span>Catégorie publication*</span>
          <select name="idTypeCom">
            <option value="">-- choisir --</option>
            <?php foreach ($typesCom as $type): ?>
              <option value="<?= (int)$type['idTypeCom'] ?>"
                <?= (!empty($formData['idTypeCom']) && (int)$formData['idTypeCom'] === (int)$type['idTypeCom']) ? 'selected' : '' ?>>
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

      <aside class="eg-ajout-right">

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

        
        <!-- IMPORTANT: le bouton est bien DANS le DOM -->
        <div class="eg-ajout-publish">
          <button type="submit" class="eg-btn-main">
            <?= $editId ? 'Mettre à jour' : 'Publier' ?>
          </button>
        </div>

      </aside>

    </section>
  </form>

</main>

<?php require __DIR__ . '/../Header Footer/footer.php'; ?>
</body>
</html>
