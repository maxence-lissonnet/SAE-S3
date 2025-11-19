<?php require 'header.php'; ?>
<link rel="stylesheet" href="../Asset/style/CatalogueStyle.css">

				<div id="features-wrapper">
					<div class="container">
						<div class="row">
                            <?php foreach($articles as $article): ?>
							<div>
                                <section class="box_feature">
                                    <div class="inner">
                                        <header>
                                            <img src=<?php echo $article['imageObjet']; ?>>
                                            <h2><?php echo $article['nomObjet']; ?></h2>
                                            <p class="logo"><img src="../Asset/image/CatalogueArticle/logo personne.png" class="logo-icon"><?php echo $article['nomUser']; ?></p>
                                            <p class="logo"><img src="../Asset/image/CatalogueArticle/logo point maps.png" class="logo-icon"><?php echo $article['adresseLieuRetrait']; ?></p>
                                            <p class="logo"><img src="../Asset/image/CatalogueArticle/logo etat.png" class="logo-icon"><?php echo $article['nomEtatObjet']; ?></p>
                                        </header>
                                    </div>
                                </section>
							</div>
                            <?php endforeach;?>
						</div>

                        <form method="post">
                            <label for="name">Categorie :</label>
                            <input type="text" name="categorie" class="input-field">
                            <label for="name">Localisation :</label>
                            <input type="text" name="localisation" class="input-field">
                            <label for="name">Etat :</label>
                            <input type="text" name="etat" class="input-field">
                            <button type="submit">Rechercher</button>
                        </form>
					</div>
				</div>
<?php require 'footer.php'; ?>
