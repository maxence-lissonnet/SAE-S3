<?php
function get_bdd()
{
    static $pdo = null;
    if ($pdo === null) {
        $hostname = 'localhost';
        $user = 'root';
        $password = '';
        $db_name = 'ecogestum';

        $dsn = "mysql:host=$hostname;dbname=$db_name;charset=utf8mb4";
        $pdo =  new PDO($dsn, $user, $password);
    }

    return $pdo;
}

function get_categories()
{
    $bdd = get_bdd();
    $query = $bdd->query('SELECT DISTINCT * FROM categorie');
    $categories = $query->fetchAll(PDO::FETCH_ASSOC);
    return $categories;
}

function get_locations()
{
    $bdd = get_bdd();
    $query = $bdd->query('SELECT DISTINCT adresseLieuRetrait FROM lieu_retrait');
    $locations = $query->fetchAll(PDO::FETCH_ASSOC);
    return $locations;
}

function get_etats()
{
    $bdd = get_bdd();
    $query = $bdd->query('SELECT DISTINCT * FROM etat_objet');
    $states = $query->fetchAll(PDO::FETCH_ASSOC);
    return $states;
}
