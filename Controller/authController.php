<?php

$GLOBALS['roles'] = [
    1 => 'Presidence',
    2 => 'Directeur composante',
    3 => 'Chef de departement',
    4 => 'Responsable service',
    5 => 'Enseignant',
    6 => 'Etudiant',
    7 => 'Bureau association',
    8 => 'Visiteur',
    9 => 'Administrateur'
];

$GLOBALS['permissions'] = [
    1 => [
        'pages' => ['statistiques', 'communication', 'rapports', 'catalogue', 'points-collecte', 'signalements', 'evenements'],
        'menu' => ['profil', 'reservations', 'deconnexion']
    ],
    2 => [
        'pages' => ['catalogue', 'donner', 'gestion-demandes', 'donnees-recyclage', 'historique', 'statistiques', 'communication', 'signalements', 'evenements'],
        'menu' => ['profil', 'reservations', 'mes-dons', 'deconnexion']
    ],
    3 => [
        'pages' => ['inventaire', 'catalogue', 'donner', 'historique', 'statistiques', 'communication', 'signalements', 'evenements'],
        'menu' => ['profil', 'reservations', 'mes-dons', 'deconnexion']
    ],
    4 => [
        'pages' => ['inventaire', 'catalogue', 'donner', 'statistiques', 'communication', 'signalements', 'evenements'],
        'menu' => ['profil', 'reservations', 'mes-dons', 'deconnexion']
    ],
    5 => [
        'pages' => ['catalogue', 'donner', 'demande-objets', 'conseils-recyclage', 'communication', 'signalements', 'evenements'],
        'menu' => ['profil', 'reservations', 'mes-dons', 'deconnexion']
    ],
    6 => [
        'pages' => ['catalogue', 'donner', 'points-collecte', 'signalements', 'evenements', 'echanges', 'communication', 'statistiques'],
        'menu' => ['profil', 'reservations', 'mes-dons', 'deconnexion']
    ],
    7 => [
        'pages' => ['evenements', 'inventaire', 'communication', 'statistiques', 'signalements', 'catalogue'],
        'menu' => ['profil', 'reservations', 'deconnexion']
    ],
    8 => [
        'pages' => ['recyclage', 'statistiques', 'evenements', 'communication'],
        'menu' => ['profil', 'reservations', 'deconnexion']
    ],
    9 => [
        'pages' => ['suivi-publications', 'parametrage', 'traçage-activites', 'gestion-comptes'],
        'menu' => ['profil', 'deconnexion']
    ]
];

function getCurrentUserRole() {
    if (isset($_GET['test_role'])) {
        return (int)$_GET['test_role'];
    }
    return $_SESSION['idRole'] ?? 1;
}


function getMenuItems() {
    $userRole = getCurrentUserRole();
    return $GLOBALS['permissions'][$userRole]['menu'] ?? [];
}


?>
