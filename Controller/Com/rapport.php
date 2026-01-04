<?php
require_once __DIR__ . '/../../Model/RapportModel.php';

// --- ACTIONS POST ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_SESSION['idUser'] ?? 1;

    // SAVE (Create or Update)
    if (isset($_POST['save_metrics'])) {
        $idRapport = !empty($_POST['idRapport']) ? (int) $_POST['idRapport'] : null;
        $periode = $_POST['annee'] . '-01-01'; // Simplification: 1er Janvier de l'année

        // On ne récupère que la description, plus de metrics JSON
        $description = trim($_POST['desc'] ?? '');

        // Note: la fonction saveRapportMetrics a été mise à jour dans le modèle
        // pour prendre une string $description au lieu d'un array $metrics
        $newId = saveRapportMetrics($idRapport, $periode, $description, $idUser);

        // Redirection vers l'édition du rapport créé/modifié
        header("Location: ?page=rapport&edit=" . $newId);
        exit;
    }

    // DELETE
    if (isset($_POST['delete_rapport']) && !empty($_POST['idRapport'])) {
        deleteRapport((int) $_POST['idRapport']);
        header("Location: ?page=rapport");
        exit;
    }
}

// --- PREPARATION DE LA VUE ---

// 1. Liste des rapports (Colonne Gauche)
$listOfReports = getAllRapports();

// 2. Données du formulaire (Colonne Droite)
$reportToEdit = [
    'idRapport' => null,
    'periode' => date('Y'),
    'descRapport' => ''
];

// Si un ID est demandé en édition
if (isset($_GET['edit'])) {
    $idEdit = (int) $_GET['edit'];
    $found = getRapportById($idEdit);
    if ($found) {
        $reportToEdit = $found;
        // Extraction de l'année pour le select
        if (!empty($found['periodeRapport'])) {
            $reportToEdit['periode'] = date('Y', strtotime($found['periodeRapport']));
        }
    }
}

// Données statiques pour le tableau (toujours affiché pour l'instant comme "Détail mensuel" indicatif)
$donnees_mois = [
    ['mois' => 'Janvier', 'poids' => 200, 'taux' => 80],
    ['mois' => 'Février', 'poids' => 150, 'taux' => 70],
    ['mois' => 'Mars', 'poids' => 300, 'taux' => 90],
    ['mois' => 'Avril', 'poids' => 250, 'taux' => 75],
];

// On appelle la vue
require_once 'Vue/Communication/rapport.php';
