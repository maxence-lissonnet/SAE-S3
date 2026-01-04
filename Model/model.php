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