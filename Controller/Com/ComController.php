<?php
// Controller/contrcom.php

$idTypeCom = null;
$dateCom   = null;


// Filtre par type de communication
if (isset($_GET['type']) && $_GET['type'] !== '') {
    $idTypeCom = (int) $_GET['type'];
}

// Filtre par date (année, année-mois ou date complète)
if (isset($_GET['date']) && $_GET['date'] !== '') {
    $dateCom = trim($_GET['date']);
}

// Réinitialisation des filtres
if (isset($_GET['reset'])) {
    $idTypeCom = null;
    $dateCom   = null;
}

// Données pour la vue
$typesCom = getAllTypeCom();
$comList  = getCommunicationsFiltered($idTypeCom, $dateCom);

require_once __DIR__ . '/../../Vue/Communication/com.php';
