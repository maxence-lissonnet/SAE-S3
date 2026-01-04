<?php
require __DIR__ . '/../../Controller/Autre/HeaderController.php' ?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dons actifs - EcoGestUM</title>
    <link rel="stylesheet" href="Asset/style/donsActifsStyle.css">

    <!-- Inclusion des polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
</head>

<body>
    <div class="title">
        <div class="namePage">
            <img src="Asset/image/donsActifs/heart.svg" id="coeur">
            <h1 style="font-size: 24px;">Dons actifs</h1>
        </div>
        <div class="sous-titre">
            <div class="compteur">
                <p><em><span style="color:#D4451B; font-size:20px"><?php echo count($objects) ?> </span>objets publiés</em></p>
                <p>Cliquez sur un don pour voir son contenu.</p>
            </div>
            <div class="options">
                <a href="#" class="option" id="delete">
                    <img src="Asset/image/donsActifs/trash.svg">
                    <p>Supprimer don</p>
                </a>
                <a href="index.php?page=Don" class="option" id="add">
                    <img src="Asset/image/donsActifs/plus.svg">
                    <p>Ajouter don</p>
                </a>
            </div>
        </div>
    </div>
    <div class="containers">
        <div class="left-container">
            <?php if (count($objects) != 0): ?>
                <?php foreach ($objects as $object): ?>
                    <div class="object clickable" data-id="<?= $object['idObjet'] ?>">
                        <p class=" name"><?php echo htmlspecialchars($object['nomObjet']); ?></p>
                        <p class="address"><em><?php echo htmlspecialchars($object['nomLieuRetrait']); ?></em></p>
                        <?php if ($object['dateDispoObjet'] <= $date): ?>
                            <p class="date">Publié le <?php echo htmlspecialchars($object['dateAffichage']); ?></p>
                        <?php else: ?>
                            <div class="dateDiv">Sera publié le <?php echo htmlspecialchars($object['dateAffichage']); ?></p><img src="Asset/image/donsActifs/clock.svg"></div>
                        <?php endif; ?>
                        <hr />
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <p class="noObjects">Pas d'objets publiés</p>
            <?php endif; ?>
        </div>

        <div class="hr"></div>

        <div class="right-container">
            <p class="display-text">Affichez ici les informations de l'objet.</p>
        </div>
    </div>
    <script src="Asset/js/donsActifs.js"></script>
    <?php if (isset($_SESSION['message']) || isset($_SESSION['message2'])): ?>
        <dialog id="popup" class="modal">
            <div class="modal-content">
                <?php if (!isset($_SESSION['message2'])): ?>
                    <p><?php echo $_SESSION['message'] ?></p>
                    <button onclick="this.closest('dialog').close()">FERMER</button>
                    <button onclick="window.location.href='index.php?page=MesDons&id=<?php echo $_GET['id'] ?>&action=delete'">CONFIRMER</button>
                <?php else: ?>
                    <p><?php echo $_SESSION['message2'] ?></p>
                    <button onclick="this.closest('dialog').close();window.location.href='index.php?page=MesDons'">FERMER</button>
                <?php endif; ?>
            </div>
        </dialog>
        <?php unset($_SESSION['message']);
        unset($_SESSION['message2']); ?>
    <?php endif; ?>
</body>

<footer>
    <?php require __DIR__ . '/../Header Footer/footer.php'; ?>
</footer>



</html>