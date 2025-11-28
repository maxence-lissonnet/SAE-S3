<?php
include 'authController.php'; 

// Toujours TOUT en haut, avant le moindre HTML
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Valeurs à afficher dans le header
$prenom = $_SESSION['prenom'] ?? 'Utilisateur';
$role   = isset($_SESSION['role']) ? strtoupper($_SESSION['role']) : 'VISITEUR';

// Vérifiez que ce chemin est correct par rapport à l'emplacement de ce fichier.
// Récupère les items de menu (profil, reservations, etc.) et les pages (stats, catalogue, etc.) 
// basés sur le rôle de l'utilisateur.
$menuItems = $GLOBALS['permissions'][getCurrentUserRole()]['menu'] ?? [];
$userPages = $GLOBALS['permissions'][getCurrentUserRole()]['pages'] ?? [];

if (session_status() != 2) {
  session_start();
}

require "../../Vue/Header Footer/header.php";

?>