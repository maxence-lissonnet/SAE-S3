<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>EcoGestUM</title>

  <!-- Feuilles de style globales -->
  <link rel="stylesheet" href="../../Asset/style/headerstyle.css">
  <link rel="stylesheet" href="../../Asset/style/footerstyle.css">
  <link rel="stylesheet" href="../../Asset/style/popup.css">

  <!-- Inclusion des polices -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

</head>

<body>

  <header class="eg-header">
    <div class="eg-header-left">
      <div class="eg-logo-um">
        <!-- logo université -->
        <a href="../Autre/accueil.php"><img src="../../Asset/image/header/univ.png" alt="Le Mans Université"></a>

      </div>
      <div class="eg-header-separator"></div>

      <span class="eg-app-name">ÉcoGestUM</span>
    </div>

    <div class="eg-header-right">
      <div class="eg-user-info">
        <span class="eg-user-name"><?php echo $_SESSION['prenom']; ?></span>
        <span class="eg-user-role"><?php echo strtoupper($_SESSION['role']); ?></span>
      </div>

      <!-- icône profil -->
      <button class="eg-icon-btn" aria-label="Profil">
        <img src="../../Asset/image/header/profile.png" alt="Profil" class="eg-icon-img">
      </button>

      <!-- icône cloche -->
      <button class="eg-icon-btn eg-notif-btn" aria-label="Notifications">
        <img src="../../Asset/image/header/cloche.png" alt="Notifications" class="eg-icon-img">
        <span class="eg-notif-badge">2</span>
      </button>

      <!-- burger -->
      <button class="eg-icon-btn eg-burger-icon" aria-label="Menu">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>
  </header>