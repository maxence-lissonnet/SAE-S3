<?php

function getCategories() {
    $pdo = get_dtb();
    return $pdo->query("SELECT idCategorie, nomCategorie FROM CATEGORIE ORDER BY nomCategorie")->fetchAll(PDO::FETCH_ASSOC);
}

function getCategoryById($idCategorie) {
    $pdo = get_dtb();
    
    $stmt = $pdo->prepare("SELECT idCategorie, nomCategorie FROM CATEGORIE WHERE idCategorie = ?");
    $stmt->execute([$idCategorie]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getObjetsByCategorie($idCategorie) {
    $pdo = get_dtb();
    
    $stmt = $pdo->prepare("
        SELECT o.idObjet, o.nomObjet, o.quantiteObjet, o.dateDispoObjet
        FROM OBJET o
        WHERE o.idCategorie = ? AND o.quantiteObjet > 0
        ORDER BY o.dateDispoObjet DESC
    ");
    
    $stmt->execute([$idCategorie]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
