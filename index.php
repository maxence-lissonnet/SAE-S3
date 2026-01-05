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
require_once 'Model/ReservationModel.php';
require_once 'Model/DonsActifsModel.php';


if (isset($_GET['page'])) {
    $page = ucfirst($_GET['page']);


    $publicPages = [
        'Auth',
        'ConnexionEtu',
        'ConnexionPersonnel',
        'SelectProfil',
        'Deconnexion'
    ];

    if (!in_array($page, $publicPages) && empty($_SESSION['idUser'])) {
        header('Location: ./');
        exit;
    }

    switch ($page) {
        case 'auth':
            require_once 'Controller/Autre/authController.php';
            break;
        case 'ConseilRecyclage':
            require_once 'Controller/Autre/ConseilRecyclageController.php';
            break;
        case 'Accueil':
            require_once 'Controller/Autre/contrAccueil.php';
            break;
        case 'Evenement':
            require_once 'Controller/Autre/EventController.php';
            break;
        case 'Notifications':
            require_once 'Controller/Autre/NotifController.php';
            break;
        case 'Carte':
            require_once 'Controller/Autre/pageCarteController.php';
            break;
        case 'Communication':
            require_once 'Controller/Com/ComController.php';
            break;
        case 'DetailCommunication':
            require_once 'Controller/Com/PageComController.php';
            break;
        case 'AjoutCom':
            require_once 'Controller/Com/AjoutComController.php';
            break;
        case 'AjoutCommunication':
            require_once 'Controller/Com/AjoutComController.php';
            break;
        case 'ConnexionEtu':
            require_once 'Controller/Connexion/pageConnexionEtuController.php';
            break;
        case 'ConnexionPersonnel':
            require_once 'Controller/Connexion/pageConnexionPersoController.php';
            break;
        case 'Catalogue':
            require_once 'Controller/Objet/CatalogueArticleController.php';
            break;
        case 'DetailObjet':
            require_once 'Controller/Objet/DetaillObjetController.php';
            break;
        case 'DemandeObjet':
            require_once 'Controller/Objet/DemandeObjetController.php';
            break;
        case 'Profil':
            require_once 'Controller/Autre/ProfilController.php';
            break;
        case 'Reservation':
            require_once 'Controller/Objet/ListReservationController.php';
            break;
        case 'MesDons':
            require_once 'Controller/Objet/donsActifsController.php';
            break;
        case 'Donner':
            require_once 'Controller/Objet/donController.php';
            break;
        case 'Rapport':
            require_once 'Controller/Com/rapport.php';
            break;
        case 'Politique':
            require_once 'Controller/Autre/PolitiqueController.php';
            break;
        case 'Deconnexion':
            require_once 'Controller/ConnexionController.php';
            logout();
            break;
        default:
            require_once 'Controller/Connexion/SelectProfilController.php';
            break;
    }
} else {
    require_once 'Controller/Connexion/SelectProfilController.php';
}
?>