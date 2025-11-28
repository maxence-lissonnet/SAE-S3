<?php

function getTypesSignalement() {
    return getTypesSignalementFromDB();
}

function traiterSignalement() {
    $result = [
        'success' => false, 
        'message' => '',
    ];

    // --- 1. Vérification de l'utilisateur connecté ---
    // ATTENTION : Vérifie que ta variable de session s'appelle bien 'IdUser'
    if (empty($_SESSION['IdUser'])) {
        $result['message'] = "Vous devez être connecté pour faire un signalement.";
        return $result;
    }

    $idUserConnecte = $_SESSION['IdUser'];
    
    try {
        // --- 2. Gestion de l'image ---
        $imageData = null;
        if (!empty($_FILES['image']['tmp_name'])) {
            $file = $_FILES['image'];
            $mimeType = mime_content_type($file['tmp_name']);
            
            // Validation format
            if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
                $result['message'] = "Format d'image non valide. Accepté : JPG, PNG, GIF.";
                return $result;
            }
            
            // Validation taille (5MB)
            if ($file['size'] > 5 * 1024 * 1024) {
                $result['message'] = "L'image ne doit pas dépasser 5MB.";
                return $result;
            }
            
            $imageData = file_get_contents($file['tmp_name']);
        }

        // --- 3. Récupération et validation des champs ---
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
        
        // --- 4. Enregistrement avec l'ID de l'utilisateur ---
        enregistrerSignalement($description, $imageData, $typeSignalement, $idUserConnecte);
        
        $result['success'] = true;
        $result['message'] = 'Signalement enregistré avec succès !';
        
    } catch (Exception $e) {
        $result['message'] = $e->getMessage();
    }
    
    return $result;
}

?>
