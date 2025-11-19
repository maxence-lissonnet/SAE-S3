<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Personnels</title>
    <link rel="icon" href="../Asset/image/favicon.ico">
    <link rel="stylesheet" href="../Asset/style/pagesConnexionStyle.css">

    <!-- Inclusion des polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
</head>

<body>
    <div class="boxForm">
        <img id="logoUniv" src="../Asset/image/univ.png">
        <h1>Connexion à EcoGestUM</h1>
        <p>PERSONNELS</p>
        <div class="formConn">
            <form method="POST">
                <p id="idText">Identifiant <span style="color: red;">*</span></p>
                <input type="text" name="id" id="idTextBox">
                <p id="idText">Mot de passe <span style="color: red;">*</span></p>
                <input type="password" name="mdp" id="idTextBox">
                <p style="font-size: 16px;">Mot de passe oublié ?</p>
                <button id="boutonConnexion" type="submit">SE CONNECTER</button>
            </form>
        </div>
    </div>
    <img id="imgFond" src="../Asset/image/imagePageConnexion.png">
</body>

</html>