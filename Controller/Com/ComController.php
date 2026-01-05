<?php
// Controller/Com/ComController.php

require_once __DIR__ . '/../../Model/ComModel.php';

$idTypeCom = null;
$dateCom   = null;

// Filtre type
if (isset($_GET['type']) && $_GET['type'] !== '') {
    $idTypeCom = (int) $_GET['type'];
}

// Filtre date
if (isset($_GET['date']) && $_GET['date'] !== '') {
    $dateCom = trim($_GET['date']);
}

// Reset des filtres
if (isset($_GET['reset'])) {
    $idTypeCom = null;
    $dateCom   = null;
}

$typesCom = getAllTypeCom();
$comList  = getCommunicationsFiltered($idTypeCom, $dateCom);

require_once __DIR__ . '/../../Vue/Communication/pagecom.php';
