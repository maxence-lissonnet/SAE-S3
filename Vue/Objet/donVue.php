<?php
require '../Header Footer/header.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Don - EcoGestUM</title>
    <link rel="stylesheet" href="../../Asset/style/donStyle.css">

    <!-- Inclusion des polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="contenu">
            <h1 style="font-size: 24px;"><span>Profil</span><span style="font-size: 12px;"> - <?php echo strtoupper($_SESSION['role']); ?></span></h1>

        </div>
    </div>
</body>

</html>