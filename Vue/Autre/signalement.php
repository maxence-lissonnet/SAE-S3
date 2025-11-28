<?php
require_once __DIR__ . '/../../Model/signalementModel.php';
require_once __DIR__ . '/../../Controller/signalementController.php';
require_once __DIR__ . '/../../Controller/categorieController.php';
require_once __DIR__ . '/../Header Footer/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = traiterSignalement();
    if ($response['success']) {
        $_SESSION['message_success'] = $response['message'];
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $_SESSION['message_error'] = $response['message'];
        $_SESSION['form_data'] = $_POST; 
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

$message_success = $_SESSION['message_success'] ?? '';
$message_error = $_SESSION['message_error'] ?? '';
$form_data = $_SESSION['form_data'] ?? [];

unset($_SESSION['message_success'], $_SESSION['message_error'], $_SESSION['form_data']);

$categories = getCategories();
$types = getTypesSignalement();
?>

<link rel="stylesheet" href="../../Asset/style/signalementstyle.css">

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
      <div class="signalement-form-section">
        <div class="form-group">
          <label for="nomObjet">Nom de l'objet<span class="required">*</span></label>
          <input type="text" id="nomObjet" name="nomObjet" placeholder="Ex: Chaise bleue" required value="<?php echo htmlspecialchars($form_data['nomObjet'] ?? ''); ?>">
        </div>

        <div class="form-group">
          <label for="categorie">Catégorie<span class="required">*</span></label>
          <select id="categorie" name="categorie" required>
            <option value="">-- Sélectionner une catégorie --</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?php echo $cat['idCategorie']; ?>" <?php echo (isset($form_data['categorie']) && $form_data['categorie'] == $cat['idCategorie']) ? 'selected' : ''; ?>>
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
              <option value="<?php echo $type['idTypeSignalement']; ?>" <?php echo (isset($form_data['typeSignalement']) && $form_data['typeSignalement'] == $type['idTypeSignalement']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($type['libelleTypeSig']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="description">Description du dysfonctionnement<span class="required">*</span></label>
          <textarea id="description" name="description" placeholder="Décrivez le problème en détail..." required><?php echo htmlspecialchars($form_data['description'] ?? ''); ?></textarea>
        </div>
      </div>

      <div class="signalement-image-section">
        <label for="imageUpload" class="image-upload-area" id="imageUploadArea">
            <div class="upload-icon"><img src="../../Asset/image/header/image_televerser.png" alt="Image_televerser_ici"></div>
            <div class="upload-text">Cliquer sur le rectangle pour choisir un fichier</div>
            <input type="file" id="imageUpload" name="image" accept="image/png, image/jpeg, image/gif" style="display:none;">
        </label>
        
        <div id="image-preview-container" style="display: none;">
            <img id="image-preview" src="#" alt="Aperçu de l'image" style="max-width: 100%; max-height: 200px; margin-bottom: 10px;"/>
            <p>
                <strong>Nom:</strong> <span id="image-name"></span><br>
                <strong>Taille:</strong> <span id="image-size"></span>
            </p>
            <button id="delete-image-btn" class="delete-image-btn">Supprimer l'image</button>
        </div>
        
        <p>Formats acceptés: JPG, PNG, GIF (Max 5MB)</p>
      </div>


      <div class="signalement-info-section">
        <div class="info-block">
          <h3>Informations complémentaires</h3>
          <p>Les services concernés traiteront votre signalement dans les plus brefs délais.</p>
        </div>

        <div class="info-block">
          <p>Sachez que la demande a dû subir des traitements spécifiques. Vous recevrez un mail de l'Université afin de connaître l'avancement de votre demande régulièrement; ces deux services pour connaître l'avancement de votre demande.</p>
        </div>

        <div class="consent-block">
          <input type="checkbox" id="consent" name="consent" required <?php echo !empty($form_data['consent']) ? 'checked' : ''; ?>>
          <label for="consent">
            J'accepte que Le Mans Université traite ma demande. J'assure avoir pris connaissance des <a href="#">informations complémentaires</a> ci-<span></span>dessus.
          </label>
        </div>

        <button type="submit" class="submit-btn">ENVOYER</button>
      </div>
    </div>
  </form>
</main>

<script src="../../Asset/js/signalement.js" defer></script>

<?php
include_once __DIR__ . '/../Header Footer/footer.php';
?>
