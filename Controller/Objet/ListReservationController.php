<?php

$objects = get_reservations($_SESSION['idUser']);
$date = date('Y-m-d');


function change_data($objects)
{
    foreach ($objects as &$object) { //Le & sert simplement à faire référence à l'OBJET et non à une copie (c'est Hugo qui écrit ça)
        $object['dateAffichage'] = date('d/m/Y', strtotime($object['dateDebReservation']));
    }
    return $objects;
}
$objects = change_data($objects);

function change_item($item)
{
    $item['dateAffichage'] = date('d/m/Y', strtotime($item['dateDebReservation']));
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $type = $finfo->buffer($item['imageObjet']);
    $base = base64_encode($item['imageObjet']);
    $item['imageObjet'] = 'data:' . $type . ';base64,' . $base;
    return $item;
}


if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === 'deleteConfirmation') {
    $_SESSION['message'] = "<span style='font-size:22px;'><strong>Confirmation</strong></span><br>Voulez-vous vraiment supprimer cet objet ?<br><em><span style='color:#D4451B'><strong>ATTENTION : Cette action est irréversible</strong></em></span>";
}

if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] === 'delete') {
    delete_reservation($_GET['id']);
    $_SESSION['message2'] = "<span style='font-size:22px;'><strong>Succès</strong></span><br>L'objet a été supprimé";
    require_once __DIR__ . '/../../Vue/Objet/ListReservationVue.php';
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $item = get_reservation_by_id($id);
    $item = change_item($item);

    if (!isset($_GET['action'])) {
        require __DIR__ . '/../../Vue/Objet/DetailReservationVue.php';
        exit();
    }
}

require __DIR__ . '/../../Vue/Objet/ListReservationVue.php';
?>