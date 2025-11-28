<?php

function getTypesSignalement() {
    return getTypesSignalementFromDB();
}

function traiterSignalement() {
    $result = [
        'success' => false, 
        'message' => '',
    ];
    
    try {
        // --- Gestion de l'image ---
        $imageData = null;
        if (!empty($_FILES['image']['tmp_name'])) {
            $file = $_FILES['image'];
            $mimeType = mime_content_type($file['tmp_name']);
            if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
                $result['message'] = "Format d'image non valide. Accepté : JPG, PNG, GIF.";
                return $result;
            }
            if ($file['size'] > 5 * 1024 * 1024) {
                $result['message'] = "L'image ne doit pas dépasser 5MB.";
                return $result;
            }
            $imageData = file_get_contents($file['tmp_name']);
        }

        // --- Validation des autres champs ---
        $nomObjet = $_POST['nomObjet'] ?? '';
        $categorie = $_POST['categorie'] ?? '';
        $typeSignalement = $_POST['typeSignalement'] ?? '';
        $description = $_POST['description'] ?? '';
        $consent = $_POST['consent'] ?? '';
        
        if (empty($nomObjet) || empty($categorie) || empty($typeSignalement) || empty($description)) {
            $result['message'] = 'Tous les champs marqués d\'une * sont obligatoires.';
            return $result;
        }
        
        if (empty($consent)) {
            $result['message'] = 'Vous devez accepter les conditions pour continuer.';
            return $result;
        }
        
        // --- Enregistrement ---
        enregistrerSignalement($description, $imageData, $typeSignalement);
        
        $result['success'] = true;
        $result['message'] = 'Signalement enregistré avec succès !';
        
    } catch (Exception $e) {
        $result['message'] = $e->getMessage();
    }
    
    return $result;
}

?>
