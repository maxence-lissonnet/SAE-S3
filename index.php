<?php
require_once __DIR__ . '/vendor/autoload.php';

session_start();

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch (Exception $e) {
    die("Erreur critique : Impossible de charger le fichier .env");
}

require_once 'utils.php';
require_once 'Model/CarteModel.php';
require_once 'Model/ComModel.php';
require_once 'Model/ConnexionModel.php';
require_once 'Model/EventModel.php';
require_once 'Model/NotificationModel.php';
require_once 'Model/ObjetModel.php';
require_once 'Model/BDDModel.php'; 


if (isset($_GET['page'])) {
    if ($_GET['page'] === 'authController') {    
        require_once 'Controller/Autre/authController.php';
    }
    elseif ($_GET['page'] === 'ConseilRecyclageController') {    
        require_once 'Controller/Autre/ConseilRecyclageController.php';
    }
    else if ($_GET['page'] === 'contrAccueil') {
        require_once 'Controller/Autre/contrAccueil.php'; 
    }
    else if ($_GET['page'] === 'EventController') {
        require_once 'Controller/Autre/EventController.php'; 
    }
    else if ($_GET['page'] === 'NotifController') {
        require_once 'Controller/Autre/NotifController.php'; 
    }
    else if ($_GET['page'] === 'pageCarteController') {
        require_once 'Controller/Autre/pageCarteController.php'; 
    }
    else if ($_GET['page'] === 'ComController') {
        require_once 'Controller/Com/ComController.php'; 
    }
    else if ($_GET['page'] === 'AjoutComController') {
        require_once 'Controller/Com/AjoutComController.php'; 
    }
    else if ($_GET['page'] === 'ComController') {
        require_once 'Controller/Com/ComController.php'; 
    }
    else if ($_GET['page'] === 'pageConnexionEtuController') {
        require_once 'Controller/Connexion/pageConnexionEtuController.php'; 
    }
    else if ($_GET['page'] === 'pageConnexionPersonnelController') {
        require_once 'Controller/Connexion/pageConnexionPersonnelController.php'; 
    }
    else if ($_GET['page'] === 'CatalogueArticleController') {
        require_once 'Controller/Objet/CatalogueArticleController.php'; 
    }
    else if ($_GET['page'] === 'DetaillObjetController') {
        require_once 'Controller/Objet/DetaillObjetController.php'; 
    }
    else if ($_GET['page'] === 'ProfilController') {
        require_once 'Controller/Autre/ProfilController.php'; 
    }
    else if ($_GET['page'] === 'ReservationController') {
        require_once 'Controller/Autre/ReservationController.php'; 
    }
    else if ($_GET['page'] === 'MesDonsController') {
        require_once 'Controller/Autre/MesDonsController.php'; 
    }
    elseif ($_GET['page'] === 'Deconnexion') {
        require_once 'Controller/ConnexionController.php';
        logout(); 
    }
    else {
        require_once 'Controller/Connexion/SelectProfilController.php';
    }
} 
else {
    require_once 'Controller/Connexion/SelectProfilController.php';
}
?>