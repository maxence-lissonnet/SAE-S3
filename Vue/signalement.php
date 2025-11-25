<?php
include '../Model/model.php';
include '../Controller/signalementController.php';
include '../Controller/categorieController.php';
include 'header.php';
?>

<link rel="stylesheet" href="/SAE-S3/Asset/style/signalementstyle.css">

<?php
$message_success = '';
$message_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = traiterSignalement();
    if ($response['success']) {
        $message_success = $response['message'];
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $message_error = $response['message'];
    }
}

$categories = getCategories();
$types = getTypesSignalement();
?>

<main>
  <h1>Signalements</h1>

  <?php if ($message_success): ?>
    <div style="background: #e8f5e9; color: #2e7d32; padding: 16px; border-radius: 8px; margin-bottom: 24px; border-left: 4px solid #4caf50;">
      ✓ <?php echo htmlspecialchars($message_success); ?>
    </div>
  <?php endif; ?>

  <?php if ($message_error): ?>
    <div style="background: #ffebee; color: #c62828; padding: 16px; border-radius: 8px; margin-bottom: 24px; border-left: 4px solid #f44336;">
      ✗ <?php echo htmlspecialchars($message_error); ?>
    </div>
  <?php endif; ?>

  <div class="signalement-container">
    <!-- Colonne gauche : Formulaire -->
    <div class="signalement-form-section">
      <form method="POST" enctype="multipart/form-data" id="signalementForm">
        
        <div class="form-group">
          <label for="nomObjet">Nom de l'objet<span class="required">*</span></label>
          <input type="text" id="nomObjet" name="nomObjet" placeholder="Ex: Chaise bleue" required>
        </div>

        <div class="form-group">
          <label for="categorie">Catégorie<span class="required">*</span></label>
          <select id="categorie" name="categorie" required>
            <option value="">-- Sélectionner une catégorie --</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?php echo $cat['idCategorie']; ?>">
                <?php echo htmlspecialchars($cat['nomCategorie']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="typeSignalement">Type de dysfonctionnement<span class="required">*</span></label>
          <select id="typeSignalement" name="typeSignalement" required>
            <option value="">-- Sélectionner un type --</option>
            <?php foreach ($types as $type): ?>
              <option value="<?php echo $type['idTypeSignalement']; ?>">
                <?php echo htmlspecialchars($type['libelleTypeSig']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="description">Description du dysfonctionnement<span class="required">*</span></label>
          <textarea id="description" name="description" placeholder="Décrivez le problème en détail..." required></textarea>
        </div>

      </form>
    </div>

    <!-- Colonne centrale : Upload image -->
    <div class="signalement-image-section">
      <label for="imageUpload" class="image-upload-area" id="imageUploadArea">
        <div class="upload-icon">📤</div>
        <div class="upload-text">Cliquer sur le rectangle ou glisser-coller la fichier</div>
        <input type="file" id="imageUpload" name="image" form="signalementForm" accept="image/*">
      </label>
      <p style="font-size: 12px; color: #999; text-align: center; margin: 0;">Formats acceptés: JPG, PNG, GIF (Max 5MB)</p>
    </div>

    <!-- Colonne droite : Informations -->
    <div class="signalement-info-section">
      <div class="info-block">
        <h3>Informations complémentaires</h3>
        <p>Les services concernés traiteront votre signalement dans les plus brefs délais.</p>
      </div>

      <div class="info-block">
        <p>Sachez que la demande a dû subir des traitements spécifiques. Vous recevrez un mail de l'Université afin de connaître l'avancement de votre demande régulièrement; ces deux services pour connaître l'avancement de votre demande.</p>
      </div>

      <div class="consent-block">
        <input type="checkbox" id="consent" name="consent" form="signalementForm" required>
        <label for="consent">
          J'accepte que Le Mans Université traite ma demande. J'assure avoir pris connaissance des <a href="#" style="color: #d14a1f; text-decoration: none;">informations complémentaires</a> ci-<span style="display: block;"></span>dessus.
        </label>
      </div>

      <button type="submit" form="signalementForm" class="submit-btn">ENVOYER</button>
    </div>
  </div>
</main>

<?php
include 'footer.php';
?>
