<?php
// Toujours TOUT en haut, avant le moindre HTML
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Valeurs à afficher dans le header
$prenom = $_SESSION['prenom'] ?? 'Utilisateur';
$role   = isset($_SESSION['role']) ? strtoupper($_SESSION['role']) : 'VISITEUR';

// Vérifiez que ce chemin est correct par rapport à l'emplacement de ce fichier.
include '../../Controller/authController.php'; 
// Récupère les items de menu (profil, reservations, etc.) et les pages (stats, catalogue, etc.) 
// basés sur le rôle de l'utilisateur.
$menuItems = $GLOBALS['permissions'][getCurrentUserRole()]['menu'] ?? [];
$userPages = $GLOBALS['permissions'][getCurrentUserRole()]['pages'] ?? [];

if (session_status() != 2) {
  session_start();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>EcoGestUM</title>

    <link rel="stylesheet" href="../../Asset/style/headerstyle.css">
  <link rel="stylesheet" href="../../Asset/style/footerstyle.css">
  <link rel="stylesheet" href="../../Asset/style/popup.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
</head>

<body>

  <header class="eg-header">
    <div class="eg-header-left">
      <div class="eg-logo-um">
                <a href="../Autre/accueil.php">
          <img src="../../Asset/image/header/univ.png" alt="Le Mans Université">
        </a>
      </div>
      <div class="eg-header-separator"></div>

      <span class="eg-app-name">ÉcoGestUM</span>
    </div>

    <div class="eg-header-right">
      <div class="eg-user-info">
        <span class="eg-user-name">
          <?= htmlspecialchars($prenom) ?>
        </span>
        <span class="eg-user-role">
          <?= htmlspecialchars($role) ?>
        </span>
      </div>

            <div style="position: relative;">
        <button class="eg-icon-btn" aria-label="Profil" id="profilBtn">
                    <img src="../../Asset/image/header/profile.png" alt="Profil" class="eg-icon-img">
        </button>

                <nav class="eg-menu-compte" id="menuCompte">
          <?php
             $menuCompteLinks = [
              'profil' => ' ../Autre/profilVue.php',
              'reservations' => '/../Autre/ReservationVue.php',
              'mes-dons' => '/../Autre/MesDonsVue.php',
              'deconnexion' => '/../Autre/deconnexion.php'
            ];
            
            $menuCompteLogos = [
              'profil' => '<img src="../../Asset/image/header/profile.png" alt="Profil" class="logo-icon">',
              'reservations' => '<img src="../../Asset/image/header/panier.png" alt="Réservations" class="logo-icon" >', // À vérifier
              'mes-dons' => '<img src="../../Asset/image/header/heart.png" alt="Mes Dons" class="logo-icon">', // À vérifier
              'deconnexion' => '<img src="../../Asset/image/header/off.png" alt="Déconnexion" class="logo-icon">', // À vérifier
            ];
            
            // $menuItems contient les clés ('profil', 'reservations', etc.) autorisées par le rôle
            foreach ($menuCompteLinks as $item => $link) {
              if (in_array($item, $menuItems)) {
                // 1. Créer le label
                $label = ucfirst(str_replace('-', ' ', $item));
                
                // 2. Récupérer le logo (s'il existe)
                $logoTag = $menuCompteLogos[$item] ?? ''; // Utilisation de l'opérateur de coalescence
                
                // 3. Afficher le lien avec le logo et l'URL
                $content = $logoTag . ' ' . $label;
                echo '<a href="' . htmlspecialchars($link) . '" class="logo">' . $content . '</a>';
              }
            }
          ?>
        </nav>
      </div>

            <button class="eg-icon-btn eg-notif-btn" aria-label="Notifications">
        <img src="../../Asset/image/header/cloche.png" alt="Notifications" class="eg-icon-img">
        <span class="eg-notif-badge">2</span>
      </button>

            <button class="eg-icon-btn eg-burger-icon" aria-label="Menu" id="burgerBtn">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>

        <nav class="eg-burger-menu" id="burgerMenu">
      <?php
        // 1. Définition des liens/URLs des pages (Clé -> URL)
        $allPages = [
          'statistiques' => '../Autre/stats.php',
          'communication' => '../Communication/pagecom.php',
          'rapports' => '../Autre/rapports.php',
          'catalogue' => '../Objet/CatalogueArticleVue.php',
          'points-collecte' => '../autre/carteVue.php',
          'signalements' => '../signalement.php',
          'evenements' => '../Event/evenement.php',
          'donner' => '../Vue/donner.php',
          'donnees-recyclage' => '../Vue/donnees-recyclage.php',
          'demande-objets' => '../Vue/demande-objets.php',
          'conseils-recyclage' => '../Autre/conseil.php',
          'recyclage' => '../Vue/recyclage.php',
        ];

        // 2. Définition des tags <img> des logos (Clé -> Tag HTML)
        $allLogoPages = [
          // ATTENTION : Mettez à jour tous les chemins d'accès pour qu'ils soient valides.
          'statistiques' => '<img src="../../Asset/image/header/graph.png" alt="Statistiques" class="logo-icon">',
          'communication' => '<img src="../../Asset/image/header/megaphone.png" alt="Communication" class="logo-icon">',
          'rapports' => '<img src="../../Asset/image/header/rapport.png" alt="Rapports" class="logo-icon">',
          'catalogue' => '<img src="../../Asset/image/logo/logo catalogue.png" alt="Catalogue" class="logo-icon">',
          'points-collecte' => '<img src="../../Asset/image/logo/epingle.png" alt="Points de collecte" class="logo-icon">',
          'signalements' => '<img src="../../Asset/image/header/exclamation-mark.png" alt="Signalements" class="logo-icon">',
          'evenements' => '<img src="../../Asset/image/header/calendar.png" alt="Évènements" class="logo-icon">',
          'donner' => '<img src="../../Asset/image/header/recycle.png" alt="Donner" class="logo-icon">',
          'donnees-recyclage' => '<img src="../../Asset/image/header/donnees-recyclage.png" alt="Données de recyclage"  class="logo-icon">',
          'demande-objets' => '<img src="../../Asset/image/header/plus.png" alt="Demande d\'objets" class="logo-icon">',
          'conseils-recyclage' => '<img src="../../Asset/image/header/light.png" alt="Conseils de recyclage" class="logo-icon">',
          'recyclage' => '<img src="../../Asset/image/header/recyclage.png" alt="Recyclage" class="logo-icon">'
        ];
        
        // 3. Boucle et affichage (LOGIQUE OPTIMISÉE)
        // $userPages est déjà défini en haut du fichier à partir de getCurrentUserRole()
        foreach ($allPages as $page => $link) {
          if (in_array($page, $userPages)) {
            $label = ucfirst(str_replace('-', ' ', $page));
            
            // Recherche directe du logo, évite la boucle imbriquée
            $logoTag = $allLogoPages[$page] ?? '';
            
            $content = $logoTag . ' ' . $label;
            // Utilisation de htmlspecialchars pour l'URL
            echo '<a class="logo" href="' . htmlspecialchars($link) . '">' . $content . '</a>';
          }
        }
      ?>
    </nav>
  </header>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    const burgerBtn = document.getElementById('burgerBtn');
    const burgerMenu = document.getElementById('burgerMenu');
    const profilBtn = document.getElementById('profilBtn');
    const menuCompte = document.getElementById('menuCompte');

    // Gestion du menu Burger
    if (burgerBtn && burgerMenu) {
      burgerBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        burgerMenu.classList.toggle('open');
        // Ferme l'autre menu s'il est ouvert
        if (menuCompte) menuCompte.classList.remove('open');
      });
    }

    // Gestion du menu de Compte
    if (profilBtn && menuCompte) {
      profilBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        menuCompte.classList.toggle('open');
        // Ferme l'autre menu s'il est ouvert
        if (burgerMenu) burgerMenu.classList.remove('open');
      });
    }

    // Gestion des clics externes (pour fermer les menus)
    document.addEventListener('click', function () {
      if (burgerMenu) burgerMenu.classList.remove('open');
      if (menuCompte) menuCompte.classList.remove('open');
    });

    // Empêche la fermeture du menu si on clique DEDANS
    if (burgerMenu) {
      burgerMenu.addEventListener('click', function (e) {
        e.stopPropagation();
      });
    }

    // Empêche la fermeture du menu si on clique DEDANS
    if (menuCompte) {
      menuCompte.addEventListener('click', function (e) {
        e.stopPropagation();
      });
    }
  });
</script>
