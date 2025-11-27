<?php
include '../Model/model.php';
include '../Controller/signalementController.php';
include '../Controller/categorieController.php';
include 'header.php';
?>

<link rel="stylesheet" href="../Asset/style/signalementstyle.css">
<link rel="stylesheet" href="../Asset/style/footerstyle.css">

<?php
session_start();
$message_success = '';
$message_error = '';
$image_status = '';
$image_status_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = traiterSignalement();
    if ($response['success']) {
        $_SESSION['message_success'] = $response['message'];
        // Redirection pour éviter la resoumission du formulaire
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $message_error = $response['message'];
        $image_status = $response['image_status'] ?? '';
        $image_status_type = $response['image_status_type'] ?? '';
    }
}

// Afficher le message de session s'il existe
if (isset($_SESSION['message_success'])) {
    $message_success = $_SESSION['message_success'];
    unset($_SESSION['message_success']);
}

$categories = getCategories();
$types = getTypesSignalement();
?>

<main>
  <h1>Signalements</h1>

  <?php if ($message_success): ?>
    <div class="message-success">
      <?php echo htmlspecialchars($message_success); ?>
    </div>
  <?php endif; ?>

  <?php if ($message_error): ?>
    <div class="message-error">
      <?php echo htmlspecialchars($message_error); ?>
    </div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" id="signalementForm">
    <div class="signalement-container">
      <!-- Colonne gauche : Formulaire -->
      <div class="signalement-form-section">
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
      </div>

      <!-- Colonne centrale : Upload image -->
      <div class="signalement-image-section">
        <label for="imageUpload" class="image-upload-area" id="imageUploadArea">
          <div class="upload-icon"><img src="../Asset/image/header/image_televerser.png" alt="Image_televerser_ici"></div>
          <div class="upload-text">Cliquer sur le rectangle ou glisser-coller la fichier</div>
          <input type="file" id="imageUpload" name="image" accept="image/*">
        </label>
        <?php if (!empty($image_status)): ?>
            <div class="image-status <?php echo $image_status_type === 'success' ? 'message-success' : 'message-error'; ?>" style="padding: 10px; font-size: 12px; text-align: center;">
                <?php echo htmlspecialchars($image_status); ?>
            </div>
        <?php endif; ?>
        <p style="font-size: 12px; color: #999; text-align: center; margin: 0; margin-top: 8px;">Formats acceptés: JPG, PNG, GIF (Max 5MB)</p>
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
          <input type="checkbox" id="consent" name="consent" required>
          <label for="consent">
            J'accepte que Le Mans Université traite ma demande. J'assure avoir pris connaissance des <a href="#" style="color: #d14a1f; text-decoration: none;">informations complémentaires</a> ci-<span style="display: block;"></span>dessus.
          </label>
        </div>

        <button type="submit" class="submit-btn">ENVOYER</button>
      </div>
    </div>
  </form>
</main>



<?php
include 'footer.php';
?>
