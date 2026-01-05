<?php
require_once __DIR__ . '/BDDModel.php';

function db_getLastThreeStats()
{
    $pdo = get_dtb();
    $sql = "SELECT * FROM STATISTIQUE ORDER BY dateCreaStat DESC LIMIT 3";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function db_getAllStats()
{
    $pdo = get_dtb();
    $sql = "SELECT * FROM STATISTIQUE ORDER BY dateCreaStat DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function db_getStatById($idStat)
{
    $pdo = get_dtb();
    $sql = "SELECT * FROM STATISTIQUE WHERE idStat = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idStat]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function db_creerStatistique($titre, $contenu, $imageData, $idTypeStatistique, $idUser)
{
    $pdo = get_dtb();
    $sql = "INSERT INTO STATISTIQUE (titreStat, contenuStat, imageStat, dateCreaStat, idTypeStatistique, IdUser) 
            VALUES (?, ?, ?, NOW(), ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$titre, $contenu, $imageData, $idTypeStatistique, $idUser]);
}
?>