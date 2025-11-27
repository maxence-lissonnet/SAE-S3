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
    $result = [
        'success' => false, 
        'message' => '',
        'image_status' => '',
        'image_status_type' => ''
    ];
    
    try {
        // Validation de l'image en premier pour conserver le statut
        if (!empty($_FILES['image']['tmp_name'])) {
            $mimeType = mime_content_type($_FILES['image']['tmp_name']);
            if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
                $result['message'] = "Format d'image non valide. Accepté : JPG, PNG, GIF.";
                $result['image_status'] = '❌ Format invalide (JPG, PNG, GIF acceptés)';
                $result['image_status_type'] = 'error';
                return $result; // Arrêter si l'image est invalide
            }
            
            if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                $result['message'] = "L'image ne doit pas dépasser 5MB.";
                $result['image_status'] = '❌ Fichier trop gros (Max 5MB)';
                $result['image_status_type'] = 'error';
                return $result; // Arrêter si l'image est invalide
            }
            
            // Si l'image est valide, on garde son statut
            $result['image_status'] = '✓ Image acceptée (' . round($_FILES['image']['size'] / 1024, 1) . ' KB)';
            $result['image_status_type'] = 'success';
        }

        // Validation des autres champs
        $nomObjet = $_POST['nomObjet'] ?? '';
        $categorie = $_POST['categorie'] ?? '';
        $typeSignalement = $_POST['typeSignalement'] ?? '';
        $description = $_POST['description'] ?? '';
        $consent = $_POST['consent'] ?? '';
        
        if (empty($nomObjet) || empty($categorie) || empty($typeSignalement) || empty($description)) {
            $result['message'] = 'Tous les champs marqués d\'une * sont obligatoires.';
            return $result; // Retourne avec le statut de l'image
        }
        
        if (empty($consent)) {
            $result['message'] = 'Vous devez accepter les conditions pour continuer.';
            return $result; // Retourne avec le statut de l'image
        }
        
        // Si tout est valide, on procède à l'enregistrement
        $imageData = !empty($_FILES['image']['tmp_name']) ? file_get_contents($_FILES['image']['tmp_name']) : null;
        
        enregistrerSignalement($description, $imageData, $typeSignalement);
        
        $result['success'] = true;
        $result['message'] = 'Signalement enregistré avec succès !';
        
    } catch (Exception $e) {
        $result['message'] = $e->getMessage();
    }
    
    return $result;
}

?>
