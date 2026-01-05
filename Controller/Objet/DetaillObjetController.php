<?php
require_once __DIR__ . '/../../Model/ObjetModel.php';

// Si la session n'est pas démarrée, on la démarre (nécessaire pour récupérer l'ID user)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// --- LOGIQUE D'AJOUT DE RÉSERVATION (SANS REDIRECTION) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_reserver'])) {
    // Vérification simple : utilisateur connecté et ID valide
    if (!empty($_SESSION['idUser']) && $id > 0) {
        add_reservation($id, $_SESSION['idUser']);
        
        // Optionnel : Vous pouvez définir une variable pour afficher un message de succès
        $message_succes = "Objet réservé avec succès !";
    }
}
// ---------------------------------------------------------

if ($id <= 0) {
    http_response_code(400);
    echo 'ID invalide';
    exit;
}

$article = get_obj_by_id($id);

if (!$article) {
    http_response_code(404);
    echo 'Objet introuvable';
    exit;
}

require __DIR__ . '/../../Vue/Objet/DetaillObjetVue.php';
?>