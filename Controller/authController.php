<?php

$GLOBALS['roles'] = [
    1 => 'Presidence',
    5 => 'Enseignant',
    6 => 'Etudiant',
];

$GLOBALS['permissions'] = [
    1 => [
        'pages' => ['statistiques', 'communication', 'rapports', 'catalogue', 'points-collecte', 'signalements', 'evenements'],
        'menu' => ['profil', 'reservations', 'deconnexion']
    ],
    5 => [
        'pages' => ['catalogue', 'donner', 'demande-objets', 'conseils-recyclage', 'communication', 'signalements', 'evenements'],
        'menu' => ['profil', 'reservations', 'mes-dons', 'deconnexion']
    ],
    6 => [
        'pages' => ['catalogue', 'donner', 'points-collecte', 'signalements', 'evenements', 'echanges', 'communication', 'statistiques'],
        'menu' => ['profil', 'reservations', 'mes-dons', 'deconnexion']
    ],
];

function getCurrentUserRole() {
    return $_SESSION['idRole'] ?? 5;
}


?>