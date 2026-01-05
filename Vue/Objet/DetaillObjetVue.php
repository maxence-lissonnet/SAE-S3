<?php require __DIR__ . '/../../Controller/Autre/HeaderController.php'; ?>

<link rel="stylesheet" href="Asset/style/DetailObjetStyle.css">

<div class="detail-container">
    <img src="index.php?page=Image&id=<?php echo (int)$article['idObjet']; ?>" alt="">
    <div class="detail-card">
        <h1 class='position-signaler'> 
            <div class='titre-objet'> 
                <?php echo htmlspecialchars($article['nomObjet']); ?> 
                <div class="date">- <?php echo htmlspecialchars($article['dateDispoObjet']); ?> 
                </div> 
            </div> 
            <a href='index.php?page=Signalement&id=<?= (int) $article['idObjet'] ?>'>
            <img src="../../Asset/image/logo/logo white flag.png" class="signaler"></button> 
            </a>
            
        </h1>
        <div class="divider"></div>

        <p class="logo"><img src="Asset/image/logo/logo personne.png" class="logo-icon"><span class="text"><?php echo htmlspecialchars($article['nomUser']) . ' ' . htmlspecialchars($article['prenomUser']); ?></span></p>
        <p class="logo"><img src="Asset/image/logo/logo point maps.png" class="logo-icon"><span class="text"><?php echo htmlspecialchars($article['adresseLieuRetrait']); ?></span> <a class="itineraireImg" href="https://www.google.com/maps/dir/?api=1&origin=My+Location&destination=<?php echo htmlspecialchars($article['coordonneesLieuRetrait']); ?>"><img id="logo-icon" src="Asset/image/logo/itineraire.png"></a></p>
        <p class="logo"><img src="Asset/image/logo/logo shapes.png" class="logo-icon"><span class="text"><?php echo htmlspecialchars($article['nomCategorie']); ?></span></p>
        <p class="logo"><img src="Asset/image/logo/logo mesure.png" class="logo-icon"><span class="text"><?php echo htmlspecialchars($article['mesureObjet']); ?></span></p>
        <p class="logo"><img src="Asset/image/logo/logo etat.png" class="logo-icon"><span class="text"><?php echo htmlspecialchars($article['nomEtatObjet']); ?></span></p>
        <span class="desc-title">Description de l'objet</span>
        <p class="desc"><?php echo nl2br(htmlspecialchars($article['descriptionObjet'] ?? '')); ?></p>

        <a class="back-link" href="Catalogue">Retour au catalogue</a><br>
        <?php if (isset($message_succes)) : ?>
            <div style="color: green; font-weight: bold; margin-bottom: 10px;">
                <?php echo $message_succes; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['idUser'])): ?>
            <form method="post">
                <button class="button" type="submit" name="btn_reserver">Réserver cet objet</button>
            </form>
        <?php else: ?>
            <a href="index.php?page=ConnexionEtu" class="button">Se connecter pour réserver</a>
        <?php endif; ?>    
    </div>
</div>

<?php require __DIR__ . '/../Header Footer/footer.php'; ?>