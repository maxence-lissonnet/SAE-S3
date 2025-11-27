<?php
// Controller/contrEven.php

require_once __DIR__ . '/../Model/EventModel.php';

$formErrors  = [];
$eventToEdit = [];

// ====== GESTION POST : CREATION / MODIF / SUPPRESSION ======
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- SUPPRESSION ---
    if (isset($_POST['delete'], $_POST['idEvent']) && ctype_digit($_POST['idEvent'])) {
        $idEvent = (int) $_POST['idEvent'];
        deleteEvent($idEvent);

        header('Location: ?page=evenement');
        exit;
    }

    // --- CREATION / MISE A JOUR ---
    if (isset($_POST['save'])) {

        $data = [
            'nomEvent'      => trim($_POST['nomEvent'] ?? ''),
            'idTypeEvent'   => (int) ($_POST['idTypeEvent'] ?? 0),
            'dateEvent'     => $_POST['dateEvent'] ?? '',
            'heureDebEvent' => $_POST['heureDebEvent'] ?? '',
            'heureFinEvent' => $_POST['heureFinEvent'] ?? '',
            'lieuEvent'     => trim($_POST['lieuEvent'] ?? ''),
            'descEvent'     => trim($_POST['descEvent'] ?? ''),
        ];

        // === validations ===
        if ($data['nomEvent'] === '') {
            $formErrors[] = "Le nom de l'évènement est obligatoire.";
        }
        if (empty($data['idTypeEvent'])) {
            $formErrors[] = "Le type d'évènement est obligatoire.";
        }
        if ($data['dateEvent'] === '') {
            $formErrors[] = "La date est obligatoire.";
        }
        if ($data['heureDebEvent'] === '') {
            $formErrors[] = "L'heure de début est obligatoire.";
        }

        if (empty($formErrors)) {
            // update ou insert ?
            if (!empty($_POST['idEvent']) && ctype_digit($_POST['idEvent'])) {
                $idEvent = (int) $_POST['idEvent'];
                updateEvent($idEvent, $data);
            } else {
                $idEvent = insertEvent($data);
            }

            // PRG : on repasse en GET pour éviter le re-submit
            header('Location: ?page=evenement&edit=' . $idEvent);
            exit;
        } else {
            // on renvoie les données dans le formulaire
            $eventToEdit = $data;
            if (!empty($_POST['idEvent']) && ctype_digit($_POST['idEvent'])) {
                $eventToEdit['idEvent'] = (int) $_POST['idEvent'];
            }
        }
    }
}

// ====== GESTION GET : FILTRES + EVENT A EDITER ======

// Filtres pour la liste et le calendrier
$idTypeEvent = isset($_GET['type']) && $_GET['type'] !== ''
    ? (int) $_GET['type']
    : null;

$dateEvent = isset($_GET['date']) && $_GET['date'] !== ''
    ? $_GET['date']
    : null;

$lieuSearch = isset($_GET['lieu']) && $_GET['lieu'] !== ''
    ? $_GET['lieu']
    : null;

// reset des filtres
if (isset($_GET['reset'])) {
    $idTypeEvent = null;
    $dateEvent   = null;
    $lieuSearch  = null;
}

// Évènement à éditer (bouton "Modifier / détails")
if (isset($_GET['edit']) && ctype_digit($_GET['edit'])) {
    $idEdit      = (int) $_GET['edit'];
    $eventToEdit = getEventById($idEdit) ?? [];
}

// Données à passer à la vue
$typesEvenement = getAllEventTypes();
$events         = getEventsFiltered($idTypeEvent, $dateEvent, $lieuSearch);

// ====== DATE DE RÉFÉRENCE POUR LE CALENDRIER ======

// 1) priorité au paramètre month=YYYY-MM (navigation flèches)
if (isset($_GET['month']) && preg_match('#^\d{4}-\d{2}$#', $_GET['month'])) {
    $calendarRefDate = $_GET['month'] . '-01';

    // 2) sinon, si un filtre date précise est saisi, on prend son mois
} elseif (!empty($dateEvent) && preg_match('#^\d{4}-\d{2}-\d{2}$#', $dateEvent)) {
    $calendarRefDate = substr($dateEvent, 0, 7) . '-01';

    // 3) sinon, mois courant
} else {
    $calendarRefDate = date('Y-m-01');
}

// Evènements du mois pour colorer les jours du calendrier
$eventsCalendar = getEventsForMonth(substr($calendarRefDate, 0, 7), $idTypeEvent, $lieuSearch);
