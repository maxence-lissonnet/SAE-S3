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
        if (get_id($_POST['id'])) {
            return "ERREUR : Permission non accordée";
        }
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

function get_item(string $table, string $column, string $param, string $value)
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

function get_id(string $mail)
{
    $dtb = get_dtb();
    $query = $dtb->query('SELECT idRole FROM UTILISATEUR WHERE emailUser = "' . $mail . '";');
    $rs = $query->fetch(PDO::FETCH_ASSOC);
    return ($rs['idRole'] === 6 || $rs['idRole'] === 8);
}

function get_user_info()
{
    $dtb = get_dtb();
    $query = $dtb->query('SELECT * FROM UTILISATEUR WHERE emailUser = "' . $_POST['id'] . '";');
    $items = $query->fetch(PDO::FETCH_ASSOC);

    $query2 = $dtb->query('SELECT nomRole FROM `role` 
        INNER JOIN utilisateur ON `role`.idRole = utilisateur.idRole
        WHERE utilisateur.emailUser = "' . $_POST['id'] . '"');
    $role = $query2->fetch(PDO::FETCH_ASSOC);
    $items['role'] = $role['nomRole'];
    return $items;
}

function change_passwords()
{
    $pdo = get_dtb();
    $q = $pdo->query("SELECT idUser, mdpUser FROM UTILISATEUR");

    while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
        $mdp = $row['mdpUser'];

        // Détecter si déjà hashé (commence par "$2y$")
        if (!str_starts_with($mdp, '$2y$')) {

            $hash = password_hash($mdp, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("UPDATE UTILISATEUR SET mdpUser = ? WHERE idUser = ?");
            $stmt->execute([$hash, $row['idUser']]);
        }
    }
}

change_passwords();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $msgErreur = verify_fields();
    if ($msgErreur === null) {
        $msgAcces = verify_data();
        if ($msgAcces === true) {
            $user_info = get_user_info();
            session_start();
            $_SESSION['prenom'] = $user_info['prenomUser'];
            $_SESSION['role'] = $user_info['role'];
            $_SESSION['nom'] = $user_info['nomUser'];
            $_SESSION['tel'] = $user_info['telUser'];
            $_SESSION['adr'] = $user_info['adrUser'];
            $_SESSION['mail'] = $user_info['emailUser'];
            header('Location: profilVue.php');
            exit;
        }
    }
}
