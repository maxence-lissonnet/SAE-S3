<?php require __DIR__ . '/../Header Footer/header.php'; ?>

<link rel="stylesheet" href="/Annee_2_dev_web/SAE-S3/Asset/style/DetailObjetStyle.css">

<div class="detail-container">
    <img src="/Annee_2_dev_web/SAE-S3/Controller/ImageObjet.php?id=<?php echo (int)$article['idObjet']; ?>" alt="">
    <div class="detail-card">
        <h1 class='position-signaler'> <div class='titre-objet'> <?php echo htmlspecialchars($article['nomObjet']); ?> <div class="date">- <?php echo htmlspecialchars($article['dateDispoObjet']); ?> </div> </div> <img src="../../Asset/image/CatalogueArticle/logo white flag.png" class="signaler"></button> </a></h1>
        <div class="divider"></div>

        <p class="logo"><img src="../Asset/image/CatalogueArticle/logo personne.png" class="logo-icon"><span class="text"><?php echo htmlspecialchars($article['nomUser']) . ' ' . htmlspecialchars($article['prenomUser']); ?></span></p>
        <p class="logo"><img src="../Asset/image/CatalogueArticle/logo point maps.png" class="logo-icon"><span class="text"><?php echo htmlspecialchars($article['adresseLieuRetrait']); ?></span> <a class="itineraireImg" href="https://www.google.com/maps/dir/?api=1&origin=My+Location&destination=<?php echo htmlspecialchars($article['coordonneesLieuRetrait']); ?>"><img id="logo-icon" src="../../Asset/image/itineraire.png"></a></p>
        <p class="logo"><img src="../Asset/image/CatalogueArticle/logo shapes.png" class="logo-icon"><span class="text"><?php echo htmlspecialchars($article['nomCategorie']); ?></span></p>
        <p class="logo"><img src="../Asset/image/CatalogueArticle/logo mesure.png" class="logo-icon"><span class="text"><?php echo htmlspecialchars($article['mesureObjet']); ?></span></p>
        <p class="logo"><img src="../Asset/image/CatalogueArticle/logo etat.png" class="logo-icon"><span class="text"><?php echo htmlspecialchars($article['nomEtatObjet']); ?></span></p>
        <span class="desc-title">Description de l'objet</span>
        <p class="desc"><?php echo nl2br(htmlspecialchars($article['descriptionObjet'] ?? '')); ?></p>

        <a class="back-link" href="/Annee_2_dev_web/SAE-S3/Vue/CatalogueArticleVue.php">Retour au catalogue</a><br>
        <button class="button">Réserver cet objet</button>
    </div>
</div>

<?php require __DIR__ . '/../Header Footer/footer.php'; ?>