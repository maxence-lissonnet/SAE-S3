<?php
session_start();
require '../Header Footer/header.php';
require '../../Controller/pageCarteController.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Points de collecte</title>
    <link rel="icon" href="../../Asset/image/favicon.ico">
    <link rel="stylesheet" href="../../Asset/style/carteStyle.css">

    <!-- Inclusion des polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <!-- Inclusion carte -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>

<body>
    <div class="title">
        <img id="pin" src="../../Asset/image/logo/epingle.png">
        <h1>Points de collecte</h1>
    </div>

    <div class="carte">
        <div id="map"></div>

        <div id="infos">
            <h1 id="textTitleZone">Dans cette zone</h1>
            <p style="font-size: 14px;"><i><strong>Cliquez pour voir le lieu sur la carte - Dézoomez pour plus de résultats</strong></i></p>
            <div id="listeLieux"></div>
        </div>
    </div>

    <script>
        const lieux = <?php echo json_encode($lieux) ?>;
    </script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="../../Asset/js/map.js"></script>
</body>

</html>