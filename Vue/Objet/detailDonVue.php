<h2><?php echo htmlspecialchars($item['nomObjet']); ?></h2>
<p class="date">Publié le <?php echo htmlspecialchars($item['dateAffichage']); ?></p>
<div class="hr-right"></div>
<div class="content">
    <div class="left-image">
        <img src="<?php echo htmlspecialchars($item['imageObjet']) ?>" alt="Image de l'objet" id="imageAffichage">
    </div>
    <div class="right-text">
        <div class="element">
            <img src="/SAE-S3/Asset/image/donsActifs/maps.svg">
            <p><?php echo htmlspecialchars($item['nomLieuRetrait']) ?><br /><?php echo htmlspecialchars($item['adresseLieuRetrait']) ?></p>
        </div>
        <div class="element">
            <img src="/SAE-S3/Asset/image/donsActifs/shapes.svg">
            <p><?php echo htmlspecialchars($item['nomCategorie']) ?></p>
        </div>
        <div class="element">
            <img src="/SAE-S3/Asset/image/donsActifs/smiley.svg">
            <p><?php echo htmlspecialchars($item['nomEtatObjet']) ?></p>
        </div>
        <div class="element">
            <img src="/SAE-S3/Asset/image/donsActifs/basket.svg">
            <p>Lot de <?php echo htmlspecialchars($item['quantiteObjet']) ?></p>
        </div>
        <div class="element">
            <img src="/SAE-S3/Asset/image/donsActifs/ruler.svg">
            <?php if (!empty($item['mesureObjet'])): ?>
                <p><?php echo htmlspecialchars($item['mesureObjet']) ?></p>
            <?php else: ?>
                <p>Pas d'information disponible</p>
            <?php endif; ?>
        </div>
        <div class="element">
            <img src="/SAE-S3/Asset/image/donsActifs/text.svg">
            <p><?php echo $item['descriptionObjet'] ?></p>
        </div>
    </div>
</div>