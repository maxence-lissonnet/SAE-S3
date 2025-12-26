<?php
function get_bdd()
{
    static $pdo = null;
    if ($pdo === null) {
        $hostname = $_ENV['DB_HOST_NAME'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];
        $db_name = $_ENV['DB_NAME'];

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
    $query = $bdd->query('SELECT DISTINCT * FROM lieu_retrait');
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

function add_object()
{
    $bdd = get_bdd();
    $query = $bdd->prepare('INSERT INTO OBJET(nomObjet, descriptionObjet, imageObjet, quantiteObjet, dateDispoObjet, mesureObjet, idCategorie, idLieuRetrait, idEtatObjet, idUser)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');
    return $query->execute([$_POST['nom'], $_POST['description'], $_POST['files'], $_POST['quantite'], $_POST['disponibilite'], $_POST['mesures'], $_POST['categorie'], $_POST['lieuRetrait'], $_POST['etat'], $_SESSION['idUser']]);
}
