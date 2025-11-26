<?php
// Controller/contrajouecom.php

require_once __DIR__ . '/../../Model/ComModel.php';

$formErrors = [];
$formData   = [];
$editId     = null;

// Types de com + rôles (pour le formulaire)
$typesCom = getAllTypeCom();
$roles    = getAllRoles();

/*
 * MODE ÉDITION : on arrive en GET avec ?id=...
 * => on charge la com et on pré-remplit le formulaire
 */
if (
    $_SERVER['REQUEST_METHOD'] === 'GET'
    && isset($_GET['id'])
    && ctype_digit($_GET['id'])
) {
    $editId  = (int) $_GET['id'];
    $current = getCommunicationById($editId);

    if ($current) {
        $formData = [
            'titreCom'   => $current['titreCom'],
            'idTypeCom'  => $current['idTypeCom'],
            'contenuCom' => $current['contenuCom'],
            'imageUrl'   => '',
            'roles'      => [],
        ];
    }
}

/*
 * SOUMISSION DU FORMULAIRE (création ou modification)
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // si on vient d'une modification, on récupère l'id caché
    if (isset($_POST['idCom']) && ctype_digit($_POST['idCom'])) {
        $editId = (int) $_POST['idCom'];
    }

    $formData = [
        'titreCom'   => trim($_POST['titreCom'] ?? ''),
        'idTypeCom'  => (int) ($_POST['idTypeCom'] ?? 0),
        'contenuCom' => trim($_POST['contenuCom'] ?? ''),
        'imageUrl'   => trim($_POST['imageUrl'] ?? ''),
        'roles'      => isset($_POST['roles']) && is_array($_POST['roles'])
                        ? array_map('intval', $_POST['roles'])
                        : [],
    ];

    // Validations
    if ($formData['titreCom'] === '') {
        $formErrors[] = "Le titre de la publication est obligatoire.";
    }
    if (empty($formData['idTypeCom'])) {
        $formErrors[] = "La catégorie de publication est obligatoire.";
    }
    if ($formData['contenuCom'] === '') {
        $formErrors[] = "La description est obligatoire.";
    }

    if (empty($formErrors)) {
        // Données communes pour insert / update
        $dataPersist = [
            'titreCom'   => $formData['titreCom'],
            'idTypeCom'  => $formData['idTypeCom'],
            'contenuCom' => $formData['contenuCom'],
            'IdUser'     => 1,  // plus tard : IdUser connecté
        ];

        if ($editId !== null) {
            // UPDATE
            updateCommunication($editId, $dataPersist);
            $idCom = $editId;
        } else {
            // INSERT
            $idCom = insertCommunication($dataPersist);
        }

        // après création / modification, on affiche la fiche
        header('Location: com.php?id=' . $idCom);
        exit;
    }
}
