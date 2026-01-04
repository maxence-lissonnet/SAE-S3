<?php
require_once __DIR__ . '/../../Model/DonModel.php';
// Valeurs par défaut
$categories = get_categories_Don();
$locations = get_locations_Don();
$etats = get_etats_Don();

function get_dates()
{
    $date = new DateTime();
    $limitDate = new DateTime();
    $limitDate->modify("+5 years");
    return array($date->format('Y-m-d'), $limitDate->format('Y-m-d'));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
    $image = file_get_contents($_FILES['files']['tmp_name']);
    if (add_object_Don($image)) {
        $_SESSION['message'] = "<strong>L'objet a bien été publié !</strong></br><em>Retrouvez le dans la page des Dons actifs.</em>";
    } else {
        $_SESSION['message'] = "<strong>Erreur d'insertion dans la base de données !</strong>";
    }
}

$dates = get_dates();

require __DIR__ . "/../../Vue/Objet/donVue.php";
