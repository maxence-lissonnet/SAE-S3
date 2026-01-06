<?php
require_once __DIR__ . '/../../Controller/Autre/HeaderController.php';
?>

<link rel="stylesheet" href="Asset/style/demandeObjetStyle.css">

<main>
    <h1>Effectuer une demande d'objets</h1>
    <p class="subtitle">Indiquez les éléments souhaités dans les champs</p>

    <?php if (!empty($message)): ?>
        <div class="<?php echo $isSuccess ? 'message-success' : 'message-error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="demande-container">
            <div class="form-section">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nomObjet">Nom de l'objet souhaité<span class="required">*</span></label>
                        <input type="text" id="nomObjet" name="nomObjet" required
                            value="<?php echo htmlspecialchars($_POST['nomObjet'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="quantite">Quantité souhaitée<span class="required">*</span></label>
                        <input type="number" id="quantite" name="quantite" min="1" max="99" required
                            value="<?php echo htmlspecialchars($_POST['quantite'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="lieuRetrait">Lieu de retrait souhaité<span class="required">*</span></label>
                        <select id="lieuRetrait" name="lieuRetrait" required>
                            <option value="">-- Choisir un lieu --</option>
                            <?php if (!empty($lieux)): ?>
                                <?php foreach ($lieux as $lieu): ?>
                                    <option value="<?php echo $lieu['idLieuRetrait']; ?>"
                                        <?php echo (isset($_POST['lieuRetrait']) && $_POST['lieuRetrait'] == $lieu['idLieuRetrait']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($lieu['nomLieuRetrait']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="mesures">Mesures (indiquez l'unité)</label>
                        <input type="text" id="mesures" name="mesures"
                            value="<?php echo htmlspecialchars($_POST['mesures'] ?? ''); ?>">
                    </div>

                    <div class="form-group full-width">
                        <label for="categorie">Catégorie de l'objet<span class="required">*</span></label>
                        <select id="categorie" name="categorie" required>
                            <option value="">-- Choisir une catégorie --</option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['idCategorie']; ?>" <?php echo (isset($_POST['categorie']) && $_POST['categorie'] == $cat['idCategorie']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['nomCategorie']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <p class="info-text">N'indiquez rien si cela n'a pas d'importance pour vous</p>
                    </div>
                </div>
            </div>

            <div class="demande-info">
                <p>Une notification sera envoyée à tous les utilisateurs de la plateforme pour leur prévenir qu'une
                    demande a été effectuée.</p>
                <p>Une fois un objet correspondant à vos critères a été publié, vous recevrez une notification vous le
                    signalant.</p>
                <form method="post">
                    <button type="submit" class="submit-btn">EFFECTUER LA DEMANDE</button>
                </form>
            </div>
        </div>
    </form>
</main>

<?php
require_once __DIR__ . '/../Header Footer/footer.php';
?>