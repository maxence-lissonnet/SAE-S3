<?php

//Récupère la BDD
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

/* A EFFACER
function updateUserPasswords()
{
    $bdd = get_dtb();
    $stmt = $bdd->query("SELECT idUser, mdpUser FROM utilisateur");

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $hashed = password_hash($row['mdpUser'], PASSWORD_DEFAULT);

        $update = $bdd->prepare("UPDATE utilisateur SET mdpUser = :hash WHERE iduser = :id");
        $update->execute([
            ':hash' => $hashed,
            ':id'   => $row['idUser']
        ]);
    }
}
*/
