<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>EcoGestUM</title>

  <!-- Feuilles de style globales -->
  <link rel="stylesheet" href="../Asset/style/headerstyle.css">
  <link rel="stylesheet" href="../Asset/style/footerstyle.css">
</head>
<body>

<?php
include '../Controller/authController.php';
$menuItems = $GLOBALS['permissions'][getCurrentUserRole()]['pages'] ?? [];
?>

<header class="eg-header">
  <div class="eg-header-left">
    <div class="eg-logo-um">
      <!-- logo université -->
      <img src="../Asset/image/header/univ.png" alt="Le Mans Université">
    </div>

    <div class="eg-header-separator"></div>

    <span class="eg-app-name">ÉcoGestUM</span>
  </div>

  <div class="eg-header-right">
    <div class="eg-user-info">
      <span class="eg-user-name">Emma</span>
      <span class="eg-user-role">RESPONSABLE DE SERVICE</span>
    </div>

    <!-- icône profil avec menu déroulant -->
    <div style="position: relative;">
      <button class="eg-icon-btn" aria-label="Profil" id="profilBtn">
        <img src="../Asset/image/header/profile.png" alt="Profil" class="eg-icon-img">
      </button>

      <!-- Menu déroulant profil/compte -->
      <nav class="eg-menu-compte" id="menuCompte">
        <?php
          $menuCompte = [
            'profil' => '/SAE-S3/Vue/profil.php',
            'reservations' => '/SAE-S3/Vue/reservations.php',
            'mes-dons' => '/SAE-S3/Vue/mes-dons.php',
            'deconnexion' => '/SAE-S3/Vue/deconnexion.php'
          ];
          
          foreach ($menuCompte as $item => $link) {
            if (in_array($item, $menuItems)) {
              $label = ucfirst(str_replace('-', ' ', $item));
              echo '<a href="' . $link . '">' . $label . '</a>';
            }
          }
        ?>
      </nav>
    </div>

    <!-- icône cloche -->
    <button class="eg-icon-btn eg-notif-btn" aria-label="Notifications">
      <img src="../Asset/image/header/cloche.png" alt="Notifications" class="eg-icon-img">
      <span class="eg-notif-badge">2</span>
    </button>

    <!-- burger -->
    <button class="eg-icon-btn eg-burger-icon" aria-label="Menu" id="burgerBtn">
      <span></span>
      <span></span>
      <span></span>
    </button>
  </div>

  <!-- Menu déroulant burger - Pages accessibles -->
  <nav class="eg-burger-menu" id="burgerMenu">
    <?php
      $allPages = [
        'statistiques' => '/SAE-S3/Vue/stats.php',
        'communication' => '/SAE-S3/Vue/communication.php',
        'rapports' => '/SAE-S3/Vue/rapports.php',
        'catalogue' => '/SAE-S3/Vue/catalogue.php',
        'points-collecte' => '/SAE-S3/Vue/points-collecte.php',
        'signalements' => '/SAE-S3/Vue/signalement.php',
        'evenements' => '/SAE-S3/Vue/evenements.php',
        'donner' => '/SAE-S3/Vue/donner.php',
        'gestion-demandes' => '/SAE-S3/Vue/gestion-demandes.php',
        'donnees-recyclage' => '/SAE-S3/Vue/donnees-recyclage.php',
        'historique' => '/SAE-S3/Vue/historique.php',
        'inventaire' => '/SAE-S3/Vue/inventaire.php',
        'demande-objets' => '/SAE-S3/Vue/demande-objets.php',
        'conseils-recyclage' => '/SAE-S3/Vue/conseils-recyclage.php',
        'echanges' => '/SAE-S3/Vue/echanges.php',
        'recyclage' => '/SAE-S3/Vue/recyclage.php',
        'suivi-publications' => '/SAE-S3/Vue/suivi-publications.php',
        'parametrage' => '/SAE-S3/Vue/parametrage.php',
        'traçage-activites' => '/SAE-S3/Vue/traçage-activites.php',
        'gestion-comptes' => '/SAE-S3/Vue/gestion-comptes.php'
      ];

      $allLogoPages = [
        'statistiques' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'communication' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'rapports' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'catalogue' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'points-collecte' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'signalements' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'evenements' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'donner' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'gestion-demandes' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'donnees-recyclage' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'historique' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'inventaire' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'demande-objets' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'conseils-recyclage' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'echanges' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'recyclage' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'suivi-publications' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'parametrage' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'traçage-activites' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
        'gestion-comptes' => '<img src="/SAE-S3/assets/logo/" alt="Logo">',
      ];
      
      $userPages = $GLOBALS['permissions'][getCurrentUserRole()]['pages'] ?? [];
      
      foreach ($allPages as $page => $link) {
        if (in_array($page, $userPages)) {
          $label = ucfirst(str_replace('-', ' ', $page));
          echo '<a href="' . $link . '">' . $label . '</a>';
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

    if (burgerBtn && burgerMenu) {
      burgerBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        burgerMenu.classList.toggle('open');
        menuCompte.classList.remove('open');
      });
    }

    if (profilBtn && menuCompte) {
      profilBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        menuCompte.classList.toggle('open');
        if (burgerMenu) burgerMenu.classList.remove('open');
      });
    }

    document.addEventListener('click', function () {
      if (burgerMenu) burgerMenu.classList.remove('open');
      if (menuCompte) menuCompte.classList.remove('open');
    });

    if (burgerMenu) {
      burgerMenu.addEventListener('click', function (e) {
        e.stopPropagation();
      });
    }

    if (menuCompte) {
      menuCompte.addEventListener('click', function (e) {
        e.stopPropagation();
      });
    }
  });
</script>
