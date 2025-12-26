<?php
require_once __DIR__ . '/../../Model/DonModel.php';
// Valeurs par défaut
$categories = get_categories();
$locations = get_locations();
$etats = get_etats();

function get_dates()
{
    $date = new DateTime();
    $limitDate = new DateTime();
    $limitDate->modify("+5 years");
    return array($date->format('Y-m-d'), $limitDate->format('Y-m-d'));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
    if (add_object()) {
        $_SESSION['message'] = "<strong>L'objet a bien été publié !</strong></br><em>Retrouvez le dans la page des Dons actifs.</em>";
    } else {
        $_SESSION['message'] = "<strong>Erreur d'insertion dans la base de données !</strong>";
    }
}

$dates = get_dates();

require __DIR__ . "/../../Vue/Objet/donVue.php";
