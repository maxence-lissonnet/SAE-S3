<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>EcoGestUM</title>
  <link rel="icon" href="/SAE-S3/Asset/image/logo/favicon.ico">

  <link rel="stylesheet" href="Asset/style/headerstyle.css">
  <link rel="stylesheet" href="Asset/style/footerstyle.css">
  <link rel="stylesheet" href=" Asset/style/popup.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
    rel="stylesheet">
</head>

<body>

  <header class="eg-header">
    <div class="eg-header-left">
      <div class="eg-logo-um">
        <a href="Accueil">
          <img src="Asset/image/header/univ.png" alt="Le Mans Université">
        </a>
      </div>
      <div class="eg-header-separator"></div>

      <span class="eg-app-name">ÉcoGestUM</span>
    </div>

    <div class="eg-header-right">
      <div class="eg-user-info">
        <span class="eg-user-name">
          <?= htmlspecialchars($_SESSION['prenom']) ?>
        </span>
        <span class="eg-user-role">
          <?= htmlspecialchars($_SESSION['role']) ?>
        </span>
      </div>

      <div style="position: relative;">
        <button class="eg-icon-btn" aria-label="Profil" id="profilBtn">
          <img src="Asset/image/header/profile.png" alt="Profil" class="eg-icon-img">
        </button>

        <nav class="eg-menu-compte" id="menuCompte">
          <?php
          $menuCompteLinks = [
            'profil' => ' Profil',
            'reservations' => ' Reservation',
            'mes-dons' => ' Mes Dons',
            'deconnexion' => ' Deconnexion'
          ];

          $menuCompteLabels = [
            'profil'      => 'Profil',
            'reservation' => 'Réservations',
            'mes-dons'    => 'Mes dons',
            'deconnexion' => 'Déconnexion'
          ];

          $menuCompteLogos = [
            'profil' => '<img src="Asset/image/header/profile.png" alt="Profil" class="logo-icon">',
            'reservations' => '<img src="Asset/image/header/panier.png" alt="Réservations" class="logo-icon" >', // À vérifier
            'mes-dons' => '<img src="Asset/image/header/heart.png" alt="Mes Dons" class="logo-icon">', // À vérifier
            'deconnexion' => '<img src="Asset/image/header/off.png" alt="Déconnexion" class="logo-icon">', // À vérifier
          ];

          // $menuItems contient les clés ('profil', 'reservations', etc.) autorisées par le rôle
          foreach ($menuCompteLinks as $item => $link) {
            if (in_array($item, $menuItems)) {
              $label = $menuCompteLabels[$item] ?? str_replace('-', ' ', ucfirst($item));
              $logoTag = $menuCompteLogos[$item] ?? '';

              echo '<a href="' . htmlspecialchars($link) . '" class="logo">';
              echo $logoTag;
              echo '<span>' . htmlspecialchars($label) . '</span>'; // On utilise $label
              echo '</a>';
            }
          }
          ?>
        </nav>
      </div>

      <a href="Notifications">
        <button class="eg-icon-btn eg-notif-btn" aria-label="Notifications">
          <img src="Asset/image/header/cloche.png" alt="Notifications" class="eg-icon-img">
          <span class="eg-notif-badge"><?php echo $_SESSION['unreadCount'] ?></span>
        </button>
      </a>


      <button class="eg-icon-btn eg-burger-icon" aria-label="Menu" id="burgerBtn">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>

    <nav class="eg-burger-menu" id="burgerMenu">
      <?php
      // 1. Définition des URLs
      $allPages = [
        'statistiques'       => '../Autre/stats.php',
        'communication'      => 'Communication',
        'rapports'           => 'Rapport',
        'catalogue'          => 'Catalogue',
        'points-collecte'    => 'Carte',
        'signalements'       => '../signalement.php',
        'evenements'         => 'Evenement',
        'donner'             => '../Vue/donner.php',
        'donnees-recyclage'  => '../Vue/donnees-recyclage.php',
        'demande-objets'     => '../Vue/demande-objets.php',
        'conseils-recyclage' => 'ConseilRecyclage',
        'recyclage'          => '../Vue/recyclage.php',
      ];

      // 2. Traduction des labels pour le menu burger
      $burgerLabels = [
        'statistiques'       => 'Statistiques',
        'communication'      => 'Communication',
        'rapports'           => 'Rapports',
        'catalogue'          => 'Catalogue',
        'points-collecte'    => 'Points de collecte',
        'signalements'       => 'Signalements',
        'evenements'         => 'Évènements',
        'donner'             => 'Donner',
        'donnees-recyclage'  => 'Données de recyclage',
        'demande-objets'     => "Demande d'objets",
        'conseils-recyclage' => 'Conseils recyclage',
        'recyclage'          => 'Recyclage',
      ];

      // 3. Tags images (identiques à votre code)
      $allLogoPages = [
        'statistiques'       => '<img src="Asset/image/header/graph.png" alt="" class="logo-icon">',
        'communication'      => '<img src="Asset/image/header/megaphone.png" alt="" class="logo-icon">',
        'rapports'           => '<img src="Asset/image/header/rapport.png" alt="" class="logo-icon">',
        'catalogue'          => '<img src="Asset/image/logo/logo catalogue.png" alt="" class="logo-icon">',
        'points-collecte'    => '<img src="Asset/image/logo/epingle.png" alt="" class="logo-icon">',
        'signalements'       => '<img src="Asset/image/header/exclamation-mark.png" alt="" class="logo-icon">',
        'evenements'         => '<img src="Asset/image/header/calendar.png" alt="" class="logo-icon">',
        'donner'             => '<img src="Asset/image/header/recycle.png" alt="" class="logo-icon">',
        'donnees-recyclage'  => '<img src="Asset/image/header/donnees-recyclage.png" alt="" class="logo-icon">',
        'demande-objets'     => '<img src="Asset/image/header/plus.png" alt="" class="logo-icon">',
        'conseils-recyclage' => '<img src="Asset/image/header/light.png" alt="" class="logo-icon">',
        'recyclage'          => '<img src="Asset/image/header/recyclage.png" alt="" class="logo-icon">'
      ];

      foreach ($allPages as $page => $link) {
        if (in_array($page, $userPages)) {
          // On utilise le label du tableau burgerLabels, sinon on formate par défaut
          $label = $burgerLabels[$page] ?? ucfirst(str_replace('-', ' ', $page));
          $logoTag = $allLogoPages[$page] ?? '';

          echo '<a class="logo" href="' . htmlspecialchars($link) . '">';
          echo $logoTag . ' <span>' . htmlspecialchars($label) . '</span>';
          echo '</a>';
        }
      }
      ?>
    </nav>
  </header>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const burgerBtn = document.getElementById('burgerBtn');
      const burgerMenu = document.getElementById('burgerMenu');
      const profilBtn = document.getElementById('profilBtn');
      const menuCompte = document.getElementById('menuCompte');

      // Gestion du menu Burger
      if (burgerBtn && burgerMenu) {
        burgerBtn.addEventListener('click', function(e) {
          e.stopPropagation();
          burgerMenu.classList.toggle('open');
          // Ferme l'autre menu s'il est ouvert
          if (menuCompte) menuCompte.classList.remove('open');
        });
      }

      // Gestion du menu de Compte
      if (profilBtn && menuCompte) {
        profilBtn.addEventListener('click', function(e) {
          e.stopPropagation();
          menuCompte.classList.toggle('open');
          // Ferme l'autre menu s'il est ouvert
          if (burgerMenu) burgerMenu.classList.remove('open');
        });
      }

      // Gestion des clics externes (pour fermer les menus)
      document.addEventListener('click', function() {
        if (burgerMenu) burgerMenu.classList.remove('open');
        if (menuCompte) menuCompte.classList.remove('open');
      });

      // Empêche la fermeture du menu si on clique DEDANS
      if (burgerMenu) {
        burgerMenu.addEventListener('click', function(e) {
          e.stopPropagation();
        });
      }

      // Empêche la fermeture du menu si on clique DEDANS
      if (menuCompte) {
        menuCompte.addEventListener('click', function(e) {
          e.stopPropagation();
        });
      }
    });
  </script>