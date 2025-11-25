<?php

function getTypesSignalement() {
    $pdo = get_dtb();
    return $pdo->query("SELECT idTypeSignalement, libelleTypeSig FROM TYPE_SIGNALEMENT ORDER BY libelleTypeSig")->fetchAll(PDO::FETCH_ASSOC);
}

function enregistrerSignalement($description, $imageData, $idTypeSignalement, $idUser = 1) {
    try {
        $pdo = get_dtb();
        
        $stmt = $pdo->prepare("
            INSERT INTO SIGNALEMENT (descSignalement, imageSignalement, idTypeSignalement, IdUser)
            VALUES (?, ?, ?, ?)
        ");
        
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

function traiterSignalement() {
    $result = ['success' => false, 'message' => ''];
    
    try {
        $nomObjet = $_POST['nomObjet'] ?? '';
        $categorie = $_POST['categorie'] ?? '';
        $typeSignalement = $_POST['typeSignalement'] ?? '';
        $description = $_POST['description'] ?? '';
        $consent = $_POST['consent'] ?? '';
        
        if (empty($nomObjet) || empty($categorie) || empty($typeSignalement) || empty($description)) {
            $result['message'] = 'Tous les champs sont obligatoires.';
            return $result;
        }
        
        if (empty($consent)) {
            $result['message'] = 'Vous devez accepter les conditions pour continuer.';
            return $result;
        }
        
        $imageData = null;
        if (!empty($_FILES['image']['tmp_name'])) {
            if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                $result['message'] = 'L\'image ne doit pas dépasser 5MB.';
                return $result;
            }
            
            $mimeType = mime_content_type($_FILES['image']['tmp_name']);
            if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
                $result['message'] = 'Format d\'image non valide. Accepté : JPG, PNG, GIF.';
                return $result;
            }
            
            $imageData = file_get_contents($_FILES['image']['tmp_name']);
        }
        
        enregistrerSignalement($description, $imageData, $typeSignalement);
        
        $result['success'] = true;
        $result['message'] = 'Signalement enregistré avec succès !';
        
    } catch (Exception $e) {
        $result['message'] = $e->getMessage();
    }
    
    return $result;
}

?>
