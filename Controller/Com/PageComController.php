<?php
// Controller/Com/PageComController.php

require_once __DIR__ . '/../../Model/ComModel.php';

$com = null;

/* ======= SUPPRESSION (POST) ======= */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['delete'], $_POST['idCom'])
    && ctype_digit($_POST['idCom'])
) {
    $idCom = (int) $_POST['idCom'];
    deleteCommunication($idCom);

    header('Location: ?page=Communication');
    exit;
}

/* ======= AFFICHAGE DÉTAIL (GET ?id=...) ======= */
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $idCom = (int) $_GET['id'];
    $com   = getCommunicationById($idCom);
}

require_once __DIR__ . '/../../Vue/Communication/com.php';
