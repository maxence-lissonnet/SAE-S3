<?php require 'header.php'; ?>
<link rel="stylesheet" href="../Asset/style/CatalogueStyle.css">
    <div id="banner-wrapper">
        <div id="banner" class="box container">
            <div class="row">
                <div class="col-7 col-12-medium">
                    <h1 class="logo"><img src="../Asset/image/CatalogueArticle/logo catalogue.png" class="logo-icon-titre">Catalogue</h1>
                </div>
            </div>
        </div>
    </div>
    <div id="features-wrapper">
        <div class="container">
            <div class="row">
                <?php foreach($articles as $article): ?>
                <div>
                    <section class="box_feature">
                        <div class="inner">
                            <header>
                                <div class="image-container">
                                    <img class="image" src="../Controller/ImageObjet.php?id=<?= (int)$article['idObjet'] ?>" alt="">
                                </div>
                                <h2><?php echo htmlspecialchars($article['nomObjet']); ?></h2>
                                <p class="logo"><img src="../Asset/image/CatalogueArticle/logo personne.png" class="logo-icon"><?php echo htmlspecialchars($article['nomUser']); ?></p>
                                <p class="logo"><img src="../Asset/image/CatalogueArticle/logo point maps.png" class="logo-icon"><?php echo htmlspecialchars($article['adresseLieuRetrait']); ?></p>
                                <p class="logo"><img src="../Asset/image/CatalogueArticle/logo etat.png" class="logo-icon"><?php echo htmlspecialchars($article['nomEtatObjet']); ?></p>
                            </header>
                        </div>
                    </section>
                </div>
                <?php endforeach;?>
            </div>

            <form method="post">

                <label for="name">Categorie :</label>
                <select name="categorie" class="input-field">
                    <option value="Tous" <?php if (($selectedCategorie ?? 'Tous') === 'Tous') echo 'selected'; ?>>Tous</option>
                    <?php foreach($categories as $categorie): ?>
                        <option value="<?php echo htmlspecialchars($categorie['idCategorie']); ?>" <?php if (($selectedCategorie ?? 'Tous') == $categorie['idCategorie']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($categorie['nomCategorie']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <label for="name">Localisation :</label>
                <select name="localisation" class="input-field">
                    <option value="Tous" <?php if (($selectedLocalisation ?? 'Tous') === 'Tous') echo 'selected'; ?>>Tous</option>
                    <?php foreach($locations as $location): ?>
                        <?php $val = $location['adresseLieuRetrait']; ?>
                        <option value="<?php echo htmlspecialchars($val, ENT_QUOTES); ?>" <?php if (($selectedLocalisation ?? 'Tous') == $val) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($val); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <label for="name">Etat :</label>
                <select name="etat" class="input-field">
                    <option value="Tous" <?php if (($selectedEtat ?? 'Tous') === 'Tous') echo 'selected'; ?>>Tous</option>
                    <?php foreach($etats as $etat): ?>
                        <?php $val = $etat['nomEtatObjet']; ?>
                        <option value="<?php echo htmlspecialchars($val, ENT_QUOTES); ?>" <?php if (($selectedEtat ?? 'Tous') == $val) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($val); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Rechercher</button>
                <button type="submit" name="reset" value="1">Supprimer filtre</button>
            </form>
        </div>
    </div>
<?php require 'footer.php'; ?>
