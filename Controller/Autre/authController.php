<?php

$GLOBALS['roles'] = [
    1 => 'Presidence',
    5 => 'Enseignant',
    6 => 'Etudiant',
];

$GLOBALS['permissions'] = [
    1 => [
        'pages' => ['statistiques', 'communication', 'rapports', 'catalogue', 'points-collecte', 'signalements', 'evenements'],
        'menu' => ['profil', 'reservations', 'mes-dons', 'deconnexion']
    ],
    5 => [
        'pages' => ['catalogue', 'donner', 'demande-objets', 'conseils-recyclage', 'points-collecte', 'communication', 'signalements', 'evenements'],
        'menu' => ['profil', 'reservations', 'mes-dons', 'deconnexion']
    ],
    6 => [
        'pages' => ['catalogue', 'donner', 'points-collecte', 'signalements', 'evenements', 'communication', 'statistiques'],
        'menu' => ['profil', 'reservations', 'mes-dons', 'deconnexion']
    ],
];

function logout()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION = array();


    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();

    header("Location: ./");
    exit;
}
