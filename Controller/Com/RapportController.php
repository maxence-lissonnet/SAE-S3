<?php
require_once __DIR__ . '/../../Model/RapportModel.php';

// --- ACTIONS POST ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_SESSION['idUser'] ?? 1;

    if (isset($_POST['save_metrics'])) {
        $idRapport = !empty($_POST['idRapport']) ? (int) $_POST['idRapport'] : null;
        $yearInput = (int) $_POST['annee'];
        $description = trim($_POST['desc'] ?? '');

        $periode = $yearInput . '-01-01';

        if ($idRapport) {
            $existing = getRapportById($idRapport);
            if ($existing && !empty($existing['periodeRapport'])) {
                try {
                    $d = new DateTime($existing['periodeRapport']);
                    $d->setDate($yearInput, (int) $d->format('m'), (int) $d->format('d'));
                    $periode = $d->format('Y-m-d');
                } catch (Exception $e) {
                    $periode = $yearInput . '-01-01';
                }
            }
        } else {
            if ($yearInput === (int) date('Y')) {
                $periode = date('Y-m-d');
            } else {
                $periode = $yearInput . '-01-01';
            }
        }

        $newId = saveRapportMetrics($idRapport, $periode, $description, $idUser);

        header("Location: ?page=rapport&edit=" . $newId);
        exit;
    }

    if (isset($_POST['delete_rapport']) && !empty($_POST['idRapport'])) {
        deleteRapport((int) $_POST['idRapport']);
        header("Location: ?page=rapport");
        exit;
    }
}

// --- PREPARATION DE LA VUE ---

$listOfReports = getAllRapports();

$reportToEdit = [
    'idRapport' => null,
    'periode' => date('Y'),
    'descRapport' => ''
];

if (isset($_GET['edit'])) {
    $idEdit = (int) $_GET['edit'];
    $found = getRapportById($idEdit);
    if ($found) {
        $reportToEdit = $found;
        if (!empty($found['periodeRapport'])) {
            $reportToEdit['periode'] = date('Y', strtotime($found['periodeRapport']));
        }
    }
}



require_once 'Vue/Communication/rapport.php';
