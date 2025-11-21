<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>EcoGestUM</title>

  <!-- Feuilles de style globales -->
  <link rel="stylesheet" href="/SAE-S3/Asset/style/headerstyle.css">
  <link rel="stylesheet" href="/SAE-S3/Asset/style/footerstyle.css">
</head>
<body>

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

    <!-- icône profil -->
    <button class="eg-icon-btn" aria-label="Profil">
      <img src="../Asset/image/header/profile.png" alt="Profil" class="eg-icon-img">
    </button>

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

  <!-- Menu déroulant burger -->
  <nav class="eg-burger-menu" id="burgerMenu">
    <a href="#dashboard">Tableau de bord</a>
    <a href="#reports">Rapports</a>
    <a href="#settings">Paramètres</a>
    <a href="#help">Aide</a>
    <a href="#logout">Déconnexion</a>
  </nav>
</header>


<script>
  // Faire le menu burger selon les rôles ou y'a des pages pour certains rôles etc
  document.addEventListener('DOMContentLoaded', function () {
    const burgerBtn = document.getElementById('burgerBtn');
    const burgerMenu = document.getElementById('burgerMenu');

    if (burgerBtn && burgerMenu) {
      burgerBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        burgerMenu.classList.toggle('open');
      });

      document.addEventListener('click', function () {
        burgerMenu.classList.remove('open');
      });

      burgerMenu.addEventListener('click', function (e) {
        e.stopPropagation();
      });
    }
  });
</script>
