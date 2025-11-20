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

$msgErreur = null;
$msgAcces = null;

function verify_fields()
{
    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $id = trim($_POST['id'] ?? '');
        $mdp = trim($_POST['mdp'] ?? '');

        if ($id === '' && $mdp === '') {
            return "ERREUR : Des champs sont manquants";
        }
        if ($id === '') {
            return "ERREUR : L'identifiant est manquant";
        }
        if ($mdp === '') {
            return "ERREUR : Le mot de passe est manquant";
        }
        return null;
    }
    return null;
}

function verify_data()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $items = get_item('UTILISATEUR', 'mdpUser', "emailUser", $_POST['id']);
        if ($items === null) {
            return "ERREUR : Utilisateur inconnu";
        }
        if (!password_verify($_POST['mdp'], $items['mdpUser'])) {
            return "ERREUR : Mot de passe incorrect";
        }
        if (password_verify($_POST['mdp'], $items['mdpUser'])) {
            return true;
        }
    }
}

function get_item(string $table, string $column, string $param, mixed $value)
{
    $dtb = get_dtb();
    if (verify_table($table) == false) {
        $query = $dtb->query('SELECT ' . $column . ' FROM ' . $table . ' WHERE ' . $param . ' = "' . $value . '"');
        $items = $query->fetch(PDO::FETCH_ASSOC);
        if ($items === false) {
            return null;
        }
        return $items;
    }
    return null;
}

function verify_table(string $table): bool
{
    $dtb = get_dtb();
    $query = $dtb->query('SELECT COUNT(*)
                        FROM information_schema.tables
                        WHERE table_name = "' . $table . '";');
    $rs = $query->fetch(PDO::FETCH_ASSOC);
    return ($rs["COUNT(*)"] == 0);
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $msgErreur = verify_fields();
    if ($msgErreur === null) {
        $msgAcces = verify_data();
        if ($msgAcces === true) {
            header('Location: accueilVue.php');
            session_start(['cookie_lifetime' => 86400]);
            exit;
        }
    }
}
