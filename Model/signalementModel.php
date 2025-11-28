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

function getTypesSignalementFromDB() {
    $pdo = get_dtb();
    return $pdo->query("SELECT idTypeSignalement, libelleTypeSig FROM TYPE_SIGNALEMENT ORDER BY libelleTypeSig")->fetchAll(PDO::FETCH_ASSOC);
}

function enregistrerSignalement($description, $imageData, $idTypeSignalement, $idUser) {
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
            $idUser // L'ID est maintenant obligatoire, plus de valeur par défaut
        ]);
        
        return $result;
    } catch (Exception $e) {
        throw new Exception('Erreur lors de l\'enregistrement : ' . $e->getMessage());
    }
}
?>