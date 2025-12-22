<?php
require __DIR__ . '/../../Model/DonModel.php';

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

$dates = get_dates();
