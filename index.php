<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();



if (isset($_GET['page'])) {
    if ($_GET['page'] === 'Don') {
        require __DIR__ . '/Controller/Objet/donController.php';
    } elseif ($_GET['page'] === 'ConnexionPerso') {
        require __DIR__ . '/Controller/Connexion/pageConnexionPersoController.php';
    } elseif ($_GET['page'] === 'Carte') {
        require __DIR__ . '/Controller/pageCarteController.php';
    }
} else {
    require __DIR__ . '/Vue/Connexion/selecProfil.php';
}
