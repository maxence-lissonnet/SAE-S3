<?php
require __DIR__ . '/../Header Footer/header.php'; ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Don - EcoGestUM</title>
    <link rel="stylesheet" href="/SAE-S3/Asset/style/donStyle.css">

    <!-- Inclusion des polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="contenu">
            <div class="titrePage">
                <img id="iconeDon" src="/SAE-S3/Asset/image/dons/recyclage.png">
                <h1 style="font-size: 24px;">Donner</h1>
            </div>
            <form method="POST" class="form">
                <div class="col">
                    <div class="champ">
                        <p class="idText">Nom de l'objet<span style="color: #D4451B;">*</span> - <span id="compteurNom" style="font-size: 12px; color: #44474E; text-align: right; font-weight:bold;">0 / 150</span></p>
                        <input type="text" name="nom" id="nomObjet" class="textBox" maxlength="150" required>
                    </div>
                    <div class="champ">
                        <p class="idText">Catégorie<span style="color: red;">*</span></p>
                        <select name="categorie" class="input-field" required>
                            <option value="" selected disabled>------</option>
                            <?php foreach ($categories as $categorie): ?>
                                <option class='valeur-option' value="<?php echo htmlspecialchars($categorie['idCategorie']); ?>">
                                    <?php echo htmlspecialchars($categorie['nomCategorie']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="champ">
                        <p class="idText">État<span style="color: red;">*</span></p>
                        <select name="etat" class="input-field" required>
                            <option value="" selected disabled>------</option>
                            <?php foreach ($etats as $etat): ?>
                                <option class='valeur-option' value="<?php echo htmlspecialchars($etat['idEtatObjet']); ?>" ?>
                                    <?php echo htmlspecialchars($etat['nomEtatObjet']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="champ">
                        <p class="idText">Images (.png/.jpg/.jpeg)<span style="color: #D4451B;">*</span></p>
                        <label for="fileInput" class="chooser">
                            <span class="material-icons"><img src="/SAE-S3/Asset/image/dons/cloud.svg"></span>
                            <span>CHARGER DES IMAGES</span>
                            <span id="fileName"></span>
                        </label>
                        <input type="file" id="fileInput" name="files" accept=".png, .jpg, .jpeg" multiple="true" required>
                    </div>
                </div>
                <div class="col">
                    <div class="champ">
                        <p class="idText">Quantité donnée<span style="color: #D4451B;">*</span></p>
                        <input type="number" name="quantite" id="quantite" class="textBox" min="1" max="99" required>
                    </div>
                    <div class="champ">
                        <p class="idText">Description<span style="color: #D4451B;">*</span> - <span id="compteurDesc" style="font-size: 12px; color: #44474E; text-align: right; font-weight:bold;">0 / 1000</span></p>
                        <textarea id="description" class="textBox" name="description" maxlength="1000" spellcheck="true" required></textarea>
                    </div>
                    <div class="preview">
                        <p>Pas de fichier sélectionné</p>
                    </div>
                </div>
                <div class="col">
                    <div class="champ">
                        <p class="idText">Rendre disponible le<span style="color: #D4451B;">*</span></p>
                        <input type="date" name="disponibilite" id="disponibilite" class="textBox" min="<?php echo $dates[0] ?>" max="<?php echo $dates[1] ?>" value="<?php echo $dates[0] ?>" required>
                    </div>
                    <div class="champ">
                        <p class="idText">Mesures (indiquez l'unité)</p>
                        <input type="text" name="mesures" id="mesures" class="textBox">
                    </div>
                    <div class="champ">
                        <p class="idText">Lieu de retrait<span style="color: red;">*</span></p>
                        <select name="lieuRetrait" class="input-field" id="lieuRetrait-field" required>
                            <option value="" selected disabled>------</option>
                            <?php foreach ($locations as $location): ?>
                                <option class='valeur-option' value="<?php echo htmlspecialchars($location['idLieuRetrait']); ?>">
                                    <?php echo htmlspecialchars($location['nomLieuRetrait']); ?>
                                    - <?php echo htmlspecialchars($location['adresseLieuRetrait']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="champ">
                        <input type="submit" value="PUBLIER" id="boutonPublier">
                    </div>
                </div>
            </form>
        </div>
        <?php if (isset($_SESSION['message'])): ?>
            <dialog id="popup" class="modal">
                <div class="modal-content">
                    <p><?php echo $_SESSION['message']; ?></p>
                    <button onclick="this.closest('dialog').close()">FERMER</button>
                </div>
            </dialog>
            <?php unset($_SESSION['message']) ?>
        <?php endif; ?>
    </div>
    <script src="/SAE-S3/Asset/js/don.js"></script>
</body>

</html>