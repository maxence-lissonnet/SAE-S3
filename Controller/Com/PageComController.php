<?php
// Controller/contrpagecom.php

require_once __DIR__ . '/../../Model/ComModel.php';
require_once __DIR__ . '/../../Vue/Communication/pagecom.php';

// Communication à afficher (ou null si introuvable)
$com = null;

/**
 * 1) SUPPRESSION (POST depuis le formulaire de com.php)
 *
 * Le formulaire envoie :
 *  - method="post"
 *  - name="delete"
 *  - hidden "idCom"
 */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['delete'], $_POST['idCom'])
    && ctype_digit($_POST['idCom'])
) {
    $idCom = (int) $_POST['idCom'];

    // Suppression en base
    deleteCommunication($idCom);

    // Retour à la page liste
    header('Location: pagecom.php');
    exit;
}

/**
 * 2) AFFICHAGE D'UNE COMMUNICATION (GET ?id=...)
 */
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $idCom = (int) $_GET['id'];
    $com   = getCommunicationById($idCom);
}
// Sinon $com reste null, et la vue affichera "Communication introuvable"
