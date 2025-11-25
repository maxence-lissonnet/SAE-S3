<?php

function getLastThreeStats() {
    $pdo = get_dtb();
    
    $requete = "
        SELECT idStat, titreStat, contenuStat, imageStat, dateCreaStat, idTypeStatistique
        FROM STATISTIQUE
        ORDER BY dateCreaStat DESC, idStat DESC
        LIMIT 3
    ";
    
    $result = $pdo->query($requete);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

function getAllStats() {
    $pdo = get_dtb();
    
    $requete = "
        SELECT idStat, titreStat, contenuStat, imageStat, dateCreaStat, idTypeStatistique
        FROM STATISTIQUE
        ORDER BY dateCreaStat DESC
    ";
    
    $result = $pdo->query($requete);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

function getStatById($idStat) {
    $pdo = get_dtb();
    
    $stmt = $pdo->prepare("
        SELECT idStat, titreStat, contenuStat, imageStat, dateCreaStat, idTypeStatistique
        FROM STATISTIQUE
        WHERE idStat = ?
    ");
    
    $stmt->execute([$idStat]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function creerStatistique($titre, $contenu, $imageData, $idTypeStatistique, $idUser) {
    try {
        $pdo = get_dtb();
        
        $stmt = $pdo->prepare("
            INSERT INTO STATISTIQUE (titreStat, contenuStat, imageStat, dateCreaStat, idTypeStatistique, IdUser)
            VALUES (?, ?, ?, NOW(), ?, ?)
        ");
        
        $stmt->execute([
            $titre,
            $contenu,
            $imageData,
            $idTypeStatistique,
            $idUser
        ]);
        
        return $pdo->lastInsertId();
    } catch (Exception $e) {
        throw new Exception('Erreur lors de la création : ' . $e->getMessage());
    }
}

?>
