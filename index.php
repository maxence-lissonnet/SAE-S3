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

require_once 'Model/AccueilModel.php';
require_once 'Model/CarteModel.php';
require_once 'Model/ComModel.php';
require_once 'Model/ConnexionModel.php';
require_once 'Model/EventModel.php';
require_once 'Model/NotificationModel.php';
require_once 'Model/ObjetModel.php';
require_once 'Model/BDDModel.php';
require_once 'Model/ReservationModel.php';
require_once 'Model/DonsActifsModel.php';
require_once 'Model/signalementModel.php';

require_once 'Controller/Autre/authController.php';

$page = isset($_GET['page']) ? strtolower($_GET['page']) : (isset($_SESSION['idUser']) ? 'accueil' : 'selectprofil');

// Redirection si le user est connecté et tente d'accéder aux pages de connexion
$loginPages = ['selectprofil', 'auth', 'connexionetu', 'connexionpersonnel'];
if (isset($_SESSION['idUser']) && in_array($page, $loginPages, true)) {
    header('Location: ?page=accueil');
    exit;
}

if (isset($_SESSION['idUser'])) {
    $_SESSION['unreadCount'] = notif_getUnreadCount((int) $_SESSION['idUser']);
}

$publicPages = [
    'auth',
    'connexionetu',
    'connexionpersonnel',
    'selectprofil',
    'deconnexion'
];

if (!in_array($page, $publicPages, true) && empty($_SESSION['idUser'])) {
    header('Location: ./');
    exit;
}

if (!in_array($page, $publicPages, true) && isset($_SESSION['idRole'])) {
    // Pages accessibles à tous les utilisateurs connectés
    $commonPages = ['accueil', 'profil', 'reservation', 'mesdons', 'notifications', 'politique'];

    if (!in_array($page, $commonPages, true)) {
        $roleId = $_SESSION['idRole'];
        $allowed = array_merge(
            $GLOBALS['permissions'][$roleId]['pages'] ?? [],
            $GLOBALS['permissions'][$roleId]['menu'] ?? []
        );

        $pageToPermission = [
            'statistique' => 'statistiques',
            'rapport' => 'rapports',
            'carte' => 'points-collecte',
            'signalement' => 'signalements',
            'evenement' => 'evenements',
            'demandeobjet' => 'demande-objets',
            'conseilrecyclage' => 'conseils-recyclage',
            'detailcommunication' => 'communication',
            'ajoutcom' => 'communication',
            'detailobjet' => 'catalogue',
            'image' => 'catalogue',
        ];

        $permissionKey = $pageToPermission[$page] ?? $page;

        if (!in_array($permissionKey, $allowed, true)) {
            header('Location: ./');
            exit;
        }
    }
}

switch ($page) {

    case 'auth':
        require_once 'Controller/Autre/authController.php';
        break;

    case 'conseilrecyclage':
        require_once 'Controller/Autre/ConseilRecyclageController.php';
        break;

    case 'accueil':
        require_once 'Controller/Autre/contrAccueil.php';
        break;

    case 'evenement':
        require_once 'Controller/Autre/EventController.php';
        break;

    case 'notifications':
        require_once 'Controller/Autre/NotifController.php';
        break;

    case 'carte':
        require_once 'Controller/Autre/pageCarteController.php';
        break;
    case 'communication':
        require_once 'Controller/Com/ComController.php';
        break;

    case 'detailcommunication':
        require_once 'Controller/Com/PageComController.php';
        break;

    case 'ajoutcom':
        require_once 'Controller/Com/AjoutComController.php';
        break;
    case 'connexionetu':
        require_once 'Controller/Connexion/pageConnexionEtuController.php';
        break;

    case 'connexionpersonnel':
        require_once 'Controller/Connexion/pageConnexionPersoController.php';
        break;

    case 'catalogue':
        require_once 'Controller/Objet/CatalogueArticleController.php';
        break;

    case 'image':
        require_once 'Controller/Objet/ImageObjet.php';
        break;

    case 'detailobjet':
        require_once 'Controller/Objet/DetaillObjetController.php';
        break;

    case 'profil':
        require_once 'Controller/Autre/ProfilController.php';
        break;

    case 'reservation':
        require_once 'Controller/Objet/ListReservationController.php';
        break;

    case 'mesdons':
        require_once 'Controller/Objet/donsActifsController.php';
        break;

    case 'donner':
        require_once 'Controller/Objet/donController.php';
        break;

    case 'demandeobjet':
        require_once 'Controller/Objet/DemandeObjetController.php';
        break;

    case 'rapport':
        require_once 'Controller/Com/rapportController.php';
        break;

    case 'signalement':
        require_once 'Controller/Autre/signalementController.php';
        break;

    case 'politique':
        require_once 'Controller/Autre/PolitiqueController.php';
        break;
    case 'statistique':
        require_once 'Controller/Autre/statsController.php';
        break;

    case 'demandeobjet':
        require_once 'Controller/Objet/DemandeObjetController.php';
        break;

    case 'deconnexion':
        require_once 'Controller/Autre/authController.php';
        logout();
        break;

    default:
        require_once 'Controller/Connexion/SelectProfilController.php';
        break;
}
