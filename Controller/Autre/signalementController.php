<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../Model/signalementModel.php';

function getTypesSignalement()
{
    return getTypesSignalementFromDB();
}

function traiterSignalement()
{
    $result = [
        'success' => false,
        'message' => '',
    ];

    // Fix: Key is sensitive and usually lowercase 'idUser' in other controllers
    if (empty($_SESSION['idUser'])) {
        $result['message'] = "Vous devez être connecté pour faire un signalement.";
        return $result;
    }

    $idUserConnecte = $_SESSION['idUser'];

    try {
        $imageData = null;
        if (!empty($_FILES['image']['tmp_name'])) {
            $file = $_FILES['image'];
            $mimeType = mime_content_type($file['tmp_name']);
            if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
                $result['message'] = "Format d'image non valide. Accepté : JPG, PNG, GIF.";
                return $result;
            }
            if ($file['size'] > 5 * 1024 * 1024) {
                $result['message'] = "L'image ne doit pas dépasser 5MB.";
                return $result;
            }
            $imageData = file_get_contents($file['tmp_name']);
        }

        $nomObjet = $_POST['nomObjet'] ?? '';
        $categorie = $_POST['categorie'] ?? '';
        $typeSignalement = $_POST['typeSignalement'] ?? '';
        $description = $_POST['description'] ?? '';
        $consent = $_POST['consent'] ?? '';

        if (empty($nomObjet) || empty($categorie) || empty($typeSignalement) || empty($description)) {
            $result['message'] = 'Tous les champs marqués d\'une * sont obligatoires.';
            return $result;
        }

        if (empty($consent)) {
            $result['message'] = 'Vous devez accepter les conditions pour continuer.';
            return $result;
        }

        enregistrerSignalement($description, $imageData, $typeSignalement, $idUserConnecte);

        $result['success'] = true;
        $result['message'] = 'Signalement enregistré avec succès !';

    } catch (Exception $e) {
        $result['message'] = $e->getMessage();
    }

    return $result;
}


function getCategories()
{
    return db_getCategories();
}

function getCategoryById($idCategorie)
{
    return db_getCategoryById($idCategorie);
}

function getObjetsByCategorie($idCategorie)
{
    return db_getObjetsByCategorie($idCategorie);
}

// Logic moved to top to avoid header already sent
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = traiterSignalement();
    if ($response['success']) {
        $_SESSION['message_success'] = $response['message'];
        // Redirect to self to avoid form resubmission
        header('Location: index.php?page=signalement');
        exit;
    } else {
        $_SESSION['message_error'] = $response['message'];
        $_SESSION['form_data'] = $_POST;
        header('Location: index.php?page=signalement');
        exit;
    }
}

require_once __DIR__ . '/../../Controller/Autre/HeaderController.php';

$message_success = $_SESSION['message_success'] ?? '';
$message_error = $_SESSION['message_error'] ?? '';
$form_data = $_SESSION['form_data'] ?? [];

unset($_SESSION['message_success'], $_SESSION['message_error'], $_SESSION['form_data']);

$categories = getCategories();
$types = getTypesSignalement();

require_once __DIR__ . '/../../Vue/Autre/signalement.php';
?>