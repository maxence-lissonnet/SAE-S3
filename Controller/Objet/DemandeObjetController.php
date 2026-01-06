<?php
require_once __DIR__ . '/../../Model/DemandeObjetModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function processDemande()
{
    $result = ['success' => false, 'message' => ''];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = trim($_POST['nomObjet'] ?? '');
        $qte = trim($_POST['quantite'] ?? '');
        $idLieuRetrait = $_POST['lieuRetrait'] ?? '';
        $mesures = trim($_POST['mesures'] ?? '');
        $categorie = $_POST['categorie'] ?? '';

        if (empty($nom) || empty($qte) || empty($idLieuRetrait) || empty($categorie)) {
            $result['message'] = "Veuillez remplir tous les champs obligatoires (*).";
            return $result;
        }

        try {
            if (createDemande($nom, $qte, $idLieuRetrait, $mesures, $categorie, $_SESSION['idUser'])) {
                notification_demande($nom, $qte, $_SESSION['idUser']);
                $result['success'] = true;
                $result['message'] = "Votre demande a bien été enregistrée.";
            } else {
                $result['message'] = "Erreur lors de l'enregistrement de la demande.";
            }
        } catch (Exception $e) {
            $result['message'] = "Une erreur est survenue : " . $e->getMessage();
        }
    }
    return $result;
}

$categories = getCategoriesDemande();
$lieux = getLieuxRetrait();
$message = '';
$isSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = processDemande();
    $message = $res['message'];
    $isSuccess = $res['success'];

    if ($isSuccess) {
        $_POST = [];
    }
}



require_once __DIR__ . '/../../Vue/Objet/demandeObjetVue.php';
