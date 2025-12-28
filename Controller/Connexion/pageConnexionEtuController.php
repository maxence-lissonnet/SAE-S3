<?php

require_once __DIR__ . '/../../Model/ConnexionModel.php';

$msgErreur = null;
$msgAcces = null;

function verify_fields()
{
    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $id = trim($_POST['id'] ?? '');
        $mdp = trim($_POST['mdp'] ?? '');

        if ($id === '' && $mdp === '') {
            return "ERREUR : Des champs sont manquants";
        }
        if ($id === '') {
            return "ERREUR : L'identifiant est manquant";
        }
        if ($mdp === '') {
            return "ERREUR : Le mot de passe est manquant";
        }
        return null;
    }
    return null;
}

function verify_data()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $items = get_item('UTILISATEUR', 'mdpUser', "emailUser", $_POST['id']);
        if ($items === null) {
            return "ERREUR : Utilisateur inconnu";
        }
        if (!get_id($_POST['id'])) {
            return "ERREUR : Permission non accordée";
        }
        if (!password_verify($_POST['mdp'], $items['mdpUser'])) {
            return "ERREUR : Mot de passe incorrect";
        }
        if (password_verify($_POST['mdp'], $items['mdpUser'])) {
            return true;
        }
    }
}



change_passwords();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $msgErreur = verify_fields();
    if ($msgErreur === null) {
        $msgAcces = verify_data();
        if ($msgAcces === true) {
            $user_info = get_user_info();
            $_SESSION['prenom'] = $user_info['prenomUser'];
            $_SESSION['role'] = $user_info['role'];
            $_SESSION['nom'] = $user_info['nomUser'];
            $_SESSION['tel'] = $user_info['telUser'];
            $_SESSION['adr'] = $user_info['adrUser'];
            $_SESSION['mail'] = $user_info['emailUser'];
            $_SESSION['idUser'] = $user_info['idUser'];  
            header('Location: index.php?page=contrAccueil'); 
            exit;
        }
    }
}

require __DIR__ . '/../../Vue/Connexion/pageConnEtu.php';
