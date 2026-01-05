<?php

// Fonction de connexion (restaurée car BDDModel a été supprimé)
if (!function_exists('get_dtb')) {
    function get_dtb()
    {
        $hostname = 'localhost';
        $user = 'root';
        $password = '';
        $db_name = 'ecogestum';

        $dsn = "mysql:host=$hostname;dbname=$db_name;utf8mb4";
        try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}

// --- SIGNALEMENT ---

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

// --- CATEGORIES (Fusionné de categorieModel) ---

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