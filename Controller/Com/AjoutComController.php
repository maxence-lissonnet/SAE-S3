<?php
// Controller/Com/AjoutComController.php

require_once __DIR__ . '/../../Model/ComModel.php';

$formErrors = [];
$formData   = [];
$editId     = null;

$typesCom = getAllTypeCom();
$roles    = getAllRoles();

/* ========= MODE ÉDITION (GET AjoutCom&idCom=XX) ========= */
if (
    $_SERVER['REQUEST_METHOD'] === 'GET'
    && isset($_GET['idCom'])
    && ctype_digit($_GET['idCom'])
) {
    $editId  = (int) $_GET['idCom'];
    $current = getCommunicationById($editId);

    if ($current) {
        $formData = [
            'titreCom'   => $current['titreCom'],
            'idTypeCom'  => $current['idTypeCom'],
            'contenuCom' => $current['contenuCom'],
            'imageUrl'   => '', // tu t'en fous pour l'instant
            'roles'      => getRoleIdsForCommunication($editId), // ✅ pré-cocher
        ];
    }
}

/* ========= SOUMISSION FORMULAIRE (POST) ========= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['idCom']) && ctype_digit($_POST['idCom'])) {
        $editId = (int) $_POST['idCom'];
    }

    $formData = [
        'titreCom'   => trim($_POST['titreCom'] ?? ''),
        'idTypeCom'  => isset($_POST['idTypeCom']) ? (int) $_POST['idTypeCom'] : 0,
        'contenuCom' => trim($_POST['contenuCom'] ?? ''),
        'imageUrl'   => trim($_POST['imageUrl'] ?? ''),
        'roles'      => isset($_POST['roles']) && is_array($_POST['roles'])
                        ? array_map('intval', $_POST['roles'])
                        : [],
    ];

    // ---- VALIDATION ----
    if ($formData['titreCom'] === '') {
        $formErrors[] = "Le titre de la publication est obligatoire.";
    }
    if (empty($formData['idTypeCom'])) {
        $formErrors[] = "La catégorie de publication est obligatoire.";
    }
    if ($formData['contenuCom'] === '') {
        $formErrors[] = "La description est obligatoire.";
    }

    // ---- PERSISTENCE ----
    if (empty($formErrors)) {

        $dataPersist = [
            'titreCom'   => $formData['titreCom'],
            'idTypeCom'  => $formData['idTypeCom'],
            'contenuCom' => $formData['contenuCom'],
            'IdUser'     => $_SESSION['idUser'] ?? 1,
        ];

        if ($editId !== null) {
            updateCommunication($editId, $dataPersist);
            $idCom = $editId;
        } else {
            $idCom = insertCommunication($dataPersist);
        }

        // ✅ sauvegarde des destinataires
        replaceCommunicationRoles($idCom, $formData['roles']);

        header('Location: ?page=DetailCommunication&id=' . $idCom);
        exit;
    }
}

require_once __DIR__ . '/../../Vue/Communication/ajoucom.php';
