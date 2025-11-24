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
echo "Terminé";
