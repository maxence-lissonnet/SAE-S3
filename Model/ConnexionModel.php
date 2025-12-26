<?php

require_once __DIR__ . '/BDDModel.php';


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

?>

