<?php
// Toujours TOUT en haut, avant le moindre HTML
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Valeurs à afficher dans le header
$prenom = $_SESSION['prenom'] ?? 'Utilisateur';
$role   = isset($_SESSION['role']) ? strtoupper($_SESSION['role']) : 'VISITEUR';

// Nombre de notifications non lues (mis à jour par contrNotif.php)
$notifUnreadCount = $_SESSION['notif_unread_count'] ?? 0;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>EcoGestUM</title>

  <!-- CSS global -->
  <link rel="stylesheet" href="../../Asset/style/headerstyle.css">
  <link rel="stylesheet" href="../../Asset/style/footerstyle.css">
  <link rel="stylesheet" href="../../Asset/style/popup.css">

  <!-- Polices -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
</head>

<body>

  <header class="eg-header">
    <div class="eg-header-left">
      <div class="eg-logo-um">
        <!-- logo université cliquable vers l'accueil -->
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

      <!-- icône profil -->
      <button class="eg-icon-btn" aria-label="Profil">
        <img src="../../Asset/image/header/profile.png" alt="Profil" class="eg-icon-img">
      </button>

      <!-- icône cloche -->
      <button class="eg-icon-btn eg-notif-btn" aria-label="Notifications"
              onclick="window.location.href='../Autre/notification.php'">
        <img src="../../Asset/image/header/cloche.png" alt="Notifications" class="eg-icon-img">
        <?php if ($notifUnreadCount > 0): ?>
          <span class="eg-notif-badge"><?= (int)$notifUnreadCount ?></span>
        <?php endif; ?>
      </button>

      <!-- burger -->
      <button class="eg-icon-btn eg-burger-icon" aria-label="Menu">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>
  </header>
