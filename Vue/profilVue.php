<?php
session_start();
require '../Controller/pageProfilController.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualisation du profil</title>
    <link rel="icon" href="../Asset/image/favicon.ico">
    <link rel="stylesheet" href="../Asset/style/profilStyle.css">

    <!-- Inclusion des polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="contenu">
            <img src="../Asset/image/univ.png">
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
        </div>
    </div>
</body>

</html>