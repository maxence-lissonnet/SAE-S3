<?php
require_once __DIR__ . '/BDDModel.php';


function getTypesSignalementFromDB()
{
    $pdo = get_dtb();
    return $pdo->query("SELECT idTypeSignalement, libelleTypeSig FROM TYPE_SIGNALEMENT ORDER BY libelleTypeSig")->fetchAll(PDO::FETCH_ASSOC);
}

function enregistrerSignalement($description, $imageData, $idTypeSignalement, $idUser)
{
    try {
        $pdo = get_dtb();

        $stmt = $pdo->prepare(
            "INSERT INTO SIGNALEMENT (descSignalement, imageSignalement, idTypeSignalement, IdUser) 
             VALUES (?, ?, ?, ?)"
        );

        $result = $stmt->execute([
            $description,
            $imageData,
            $idTypeSignalement,
            $idUser
        ]);

        return $result;
    } catch (Exception $e) {
        throw new Exception('Erreur lors de l\'enregistrement : ' . $e->getMessage());
    }
}


function db_getCategories()
{
    $pdo = get_dtb();
    return $pdo->query("SELECT idCategorie, nomCategorie FROM CATEGORIE ORDER BY nomCategorie")->fetchAll(PDO::FETCH_ASSOC);
}

function db_getCategoryById($idCategorie)
{
    $pdo = get_dtb();

    $stmt = $pdo->prepare("SELECT idCategorie, nomCategorie FROM CATEGORIE WHERE idCategorie = ?");
    $stmt->execute([$idCategorie]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function db_getObjetsByCategorie($idCategorie)
{
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