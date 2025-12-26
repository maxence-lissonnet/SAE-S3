<?php
require_once __DIR__ . '/../Model/CarteModel.php';

$lieux = [];
$places = get_items('LIEU_RETRAIT');

foreach ($places as $place) {
    $latlon = explode(' ', $place['coordonneesLieuRetrait']);
    array_push($lieux, ["nom" => $place['nomLieuRetrait'], "adr" => $place['adresseLieuRetrait'], "lat" => floatval($latlon[0]), 'long' => floatval($latlon[1])]);
}

require __DIR__ . "/../Vue/Autre/carteVue.php";
