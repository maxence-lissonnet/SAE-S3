<?php

$objects = get_reservations($_SESSION['idUser']);
$date = date('Y-m-d');


if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === 'deleteConfirmation') {
    $_SESSION['message'] = "<span style='font-size:22px;'><strong>Confirmation</strong></span><br>Voulez-vous vraiment supprimer cet objet ?<br><em><span style='color:#D4451B'><strong>ATTENTION : Cette action est irréversible</strong></em></span>";
}

if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === 'delete') {
    delete_object($_GET['id']);
    $_SESSION['message2'] = "<span style='font-size:22px;'><strong>Succès</strong></span><br>L'objet a été supprimé";
    require_once ROOT . '/Vue/Objet/DonsActifsVue.php';
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $item = get_object_by_id($id);
    $item = change_item($item);

    if (!isset($_GET['action'])) {
        require ROOT . '/Vue/Objet/detailDonVue.php';
        exit();
    }
}

require __DIR__ . '/../../Vue/Objet/ListReservationVue.php';
?>