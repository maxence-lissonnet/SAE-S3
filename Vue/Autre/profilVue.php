
<?php

require_once __DIR__ . '/../Header Footer/header.php';

?>

<link rel="stylesheet" href="../../Asset/style/profilStyle.css">



<div class="container">

    <div class="contenu">

        <img src="../../Asset/image/header/univ.png">

        <h1 style="font-size: 24px;"><span>Profil</span><span style="font-size: 12px;"> - <?php echo strtoupper($_SESSION['role']); ?></span></h1>

        <div class="ligne">

            <div class="elt">

                <p class="idText">Adresse e-mail</p>

                <div class="box"><?php echo $_SESSION['mail'] ?></div>

            </div>

            <div class="elt">

                <p class="idText">Nom</p>

                <div class="box"><?php echo $_SESSION['nom'] ?></div>

            </div>

            <div class="elt">

                <p class="idText">Prénom</p>

                <div class="box"><?php echo $_SESSION['prenom'] ?></div>

            </div>

        </div>



        <div class="ligne">

            <div class="elt">

                <p class="idText">Téléphone</p>

                <div class="box"><?php echo $_SESSION['tel'] ?></div>

            </div>

            <div class="elt">

                <p class="idText">Adresse</p>

                <div class="box"><?php echo $_SESSION['adr'] ?></div>

            </div>

        </div>



        <div class="ligne">

            <button id="retourPage" onclick="history.back();">RETOUR</button>

        </div>

    </div>

</div>



<?php

require_once __DIR__ . '/../Header Footer/footer.php';

?>
