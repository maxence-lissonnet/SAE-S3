<?php
// Controller/contrAccueil.php

// modèle des événements
require_once __DIR__ . '/../Model/EventModel.php';
// modèle des communications (pour getLastCommunications)
require_once __DIR__ . '/../Model/ComModel.php';

// ------------------------------------------------------------------
// Compteur d’objets (pour l’instant en dur, à brancher plus tard)
// ------------------------------------------------------------------
$nbObjetsEnLigne = 535;

// ------------------------------------------------------------------
// Objets récents (pour l’instant : données factices)
// ------------------------------------------------------------------
$latestObjects = [
    [
        'titre'   => 'Commode années 60',
        'auteur'  => 'Nathalie VEILLARD',
        'lieu'    => 'IUT de Laval – Dpt. INFO',
        'etat'    => 'Très bon état',
        'moment'  => 'Il y a 2 heures',
    ],
    [
        'titre'   => '24 crayons aquarellables',
        'auteur'  => 'Hugo CHAUVET – INFO2',
        'lieu'    => 'Rue du Pont de Mayenne – Laval',
        'etat'    => 'Bon état',
        'moment'  => 'Il y a 7 heures',
    ],
    [
        'titre'   => 'Tableau blanc',
        'auteur'  => 'Secrétariat IUT Le Mans',
        'lieu'    => 'IUT du Mans',
        'etat'    => 'Très bon état',
        'moment'  => 'Il y a 18 heures',
    ],
];

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
// ⚠️ ces fonctions doivent exister dans EventModel.php
$homeCalEventsRaw = getEventsForMonth($homeMonth, null, null);

// Liste détaillée des évènements du mois affiché
$homeEvents = getEventsFiltered(null, $homeMonth, null);

// ------------------------------------------------------------------
// Dernières communications pour la zone "Actualités"
// (getLastCommunications doit être dans ComModel.php)
// ------------------------------------------------------------------
$homeNews = getLastCommunications(3);
