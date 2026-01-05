<?php

$nbObjetsEnLigne = get_number_of_objects();

// ------------------------------------------------------------------
// Objets récents (pour l’instant : données factices)
// ------------------------------------------------------------------
$latestObjects = get_latest_objects();

foreach ($latestObjects as $key => $object) {
    if (!empty($object['imageObjet'])) {
        $latestObjects[$key] = change_item($object);
    }
}

function change_item($item)
{
    $item['dateAffichage'] = date('d/m/Y', strtotime($item['dateDispoObjet']));
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $type = $finfo->buffer($item['imageObjet']);
    $base = base64_encode($item['imageObjet']);
    $item['imageObjet'] = 'data:' . $type . ';base64,' . $base;

    return $item;
}
// ------------------------------------------------------------------
// Gestion du mois du mini-calendrier de la page d’accueil
//   - paramètre GET ?month=YYYY-MM
//   - par défaut : mois courant
// ------------------------------------------------------------------
$homeMonth = date('Y-m');
if (!empty($_GET['month']) && preg_match('#^\d{4}-\d{2}$#', $_GET['month'])) {
    $homeMonth = $_GET['month'];
}

// Date de référence : 1er jour du mois choisi
$homeCalRefDate = $homeMonth . '-01';

// Jours qui contiennent au moins un évènement (pour colorer le mini-calendrier)
$homeCalEventsRaw = getEventsForMonth($homeMonth, null, null);

// Liste détaillée des évènements du mois affiché
// (équivalent à ce que tu vois dans la colonne bleue de la page évènements)
$homeEvents = getEventsFiltered(null, $homeMonth, null);

// ------------------------------------------------------------------
// Dernières communications pour la zone "Actualités"
// ------------------------------------------------------------------
$homeNews = getLastCommunications(3);

require_once __DIR__ . '/../../Vue/Autre/accueil.php';
