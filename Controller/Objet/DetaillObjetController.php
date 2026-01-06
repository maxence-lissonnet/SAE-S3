<?php
require_once __DIR__ . '/../../Model/ObjetModel.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_reserver'])) {
    if (!empty($_SESSION['idUser']) && $id > 0) {
        add_reservation($id, $_SESSION['idUser']);
        $message_succes = "Objet réservé avec succès !";
    }
}

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
