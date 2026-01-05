<?php require __DIR__ . '/../../Controller/Autre/HeaderController.php'; ?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dons actifs - EcoGestUM</title>
    <link rel="stylesheet" href="Asset/style/listReservationStyle.css">

    <!-- Inclusion des polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
</head>

<body>
    <div class="title">
        <div class="namePage">
            <img src="Asset/image/header/panier.png" id="panier">
            <h1 style="font-size: 24px;">Réservations</h1>
        </div>
        <div class="sous-titre">
            <div class="compteur">
                <p><em><span style="color:#D4451B; font-size:20px"><?php echo count($objects) ?> </span>réservations effectuées</em></p>
                <p>Cliquez sur une réservation pour voir son contenu.</p>
            </div>
            <div class="options">
                <a href="#" class="option" id="delete">
                    <img src="Asset/image/icon/trash.svg">
                    <p>Annuler réservation</p>
                </a>
                <a href="index.php?page=Catalogue" class="option" id="add">
                    <img src="Asset/image/icon/plus.svg">
                    <p>Effectuer une nouvelle réservation</p>
                </a>
            </div>
        </div>
    </div>
    <div class="containers">
        <div class="left-container">
            <?php if (count($objects) != 0): ?>
                <?php foreach ($objects as $object): ?>
                    <div class="object clickable" data-id="<?= $object['idObjet'] ?>" data-idreservation="<?= $object['idreservation'] ?>">
                        <p class=" name"><?php echo htmlspecialchars($object['nomObjet']); ?></p>
                        <p class="address"><em><?php echo htmlspecialchars($object['nomLieuRetrait']); ?></em></p>
                        <p class="date">Passée le <?php echo htmlspecialchars($object['dateAffichage']); ?></p>
                        <hr>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="noObjects">Pas de réservations passées</p>
            <?php endif; ?>
        </div>

        <div class="hr"></div>

        <div class="right-container">
            <p class="display-text">Affichez ici les informations de la réservation.</p>
        </div>
    </div>
    <script src="Asset/js/Reservation.js"></script>
    <?php if (isset($_SESSION['message']) || isset($_SESSION['message2'])): ?>
        <dialog id="popup" class="modal">
            <div class="modal-content">
                <?php if (!isset($_SESSION['message2'])): ?>
                    <p><?php echo $_SESSION['message'] ?></p>
                    <button onclick="this.closest('dialog').close()">FERMER</button>
                    <button onclick="window.location.href='index.php?page=Reservation&id=<?php echo $_GET['id'] ?>&action=delete'">CONFIRMER</button>
                <?php else: ?>
                    <p><?php echo $_SESSION['message2'] ?></p>
                    <button onclick="this.closest('dialog').close();window.location.href='index.php?page=Reservation'">FERMER</button>
                <?php endif; ?>
            </div>
        </dialog>
        <?php unset($_SESSION['message']);
        unset($_SESSION['message2']); ?>
    <?php endif; ?>
</body>

<?php require __DIR__ . '/../Header Footer/footer.php'; ?>




</html>