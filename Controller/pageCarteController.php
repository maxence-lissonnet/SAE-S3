<?php

function get_dtb()
{
    $hostname = 'localhost';
    $user = 'root';
    $password = '';
    $db_name = 'ecogestum';

    $dsn = "mysql:host=$hostname;dbname=$db_name;utf8mb4";
    $pdo =  new PDO($dsn, $user, $password);

    return $pdo;
}

function get_items(string $table)
{
    $dtb = get_dtb();
    $query = $dtb->query('SELECT * FROM ' . $table);
    $items = $query->fetchAll(PDO::FETCH_ASSOC);
    return $items;
}

$lieux = [];
$places = get_items('LIEU_RETRAIT');

foreach ($places as $place) {
    $latlon = explode(' ', $place['coordonneesLieuRetrait']);
    array_push($lieux, ["nom" => $place['nomLieuRetrait'], "adr" => $place['adresseLieuRetrait'], "lat" => floatval($latlon[0]), 'long' => floatval($latlon[1])]);
}
