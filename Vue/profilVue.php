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
            <div class="ligne1">
                <p id="idText">Identifiant</p>
                <div class="box"></div>
                <p id="idText">Mot de passe <span style="color: red;">*</span></p>
                <input type="password" name="mdp" id="idTextBox">
            </div>
        </div>
    </div>
</body>

</html>