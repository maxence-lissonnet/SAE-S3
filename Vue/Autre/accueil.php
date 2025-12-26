
<link rel="stylesheet" href="Asset/style/accueilstyle.css">
<?php require __DIR__ . '/../../Controller/Autre/HeaderController.php'; ?>

<main class="eg-home-page">

  <!-- ========= BLOC HERO / COMPTEUR D’OBJETS ========= -->
  <section class="eg-home-hero">
    <p class="eg-home-hello">
      Bonjour <?= htmlspecialchars($_SESSION['prenom'] ?? 'Emma') ?> !
    </p>
    <p class="eg-home-counter">
      Il y a actuellement <span class="eg-home-counter-number"><?= (int)$nbObjetsEnLigne ?></span>
      objets en ligne&nbsp;!
    </p>
  </section>

  <!-- ========= OBJETS RÉCENTS ========= -->
  <section class="eg-home-latest">
    <div class="eg-home-section-title-row">
      <h2 class="eg-home-section-title">Mis en ligne récemment</h2>
      <a href="?page=objet" class="eg-home-link-all">Voir tous les objets mis en ligne</a>
    </div>

    <div class="eg-home-latest-grid">
      <?php foreach ($latestObjects as $obj): ?>
        <article class="eg-home-object-card">
          <div class="eg-home-object-image"></div>

          <div class="eg-home-object-body">
            <h3 class="eg-home-object-title">
              <?= htmlspecialchars($obj['titre']) ?>
            </h3>
            <p class="eg-home-object-meta">
              <?= htmlspecialchars($obj['auteur']) ?><br>
              <?= htmlspecialchars($obj['lieu']) ?>
            </p>
            <p class="eg-home-object-state">
              <?= htmlspecialchars($obj['etat']) ?>
            </p>
            <p class="eg-home-object-time">
              <?= htmlspecialchars($obj['moment']) ?>
            </p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ========= ÉVÈNEMENTS ========= -->
  <section class="eg-home-events">
    <div class="eg-home-section-title-row">
      <h2 class="eg-home-section-title">Évènements</h2>
    </div>

    <div class="eg-home-events-layout">

      <!-- ===== Mini calendrier à gauche ===== -->
      <aside class="eg-home-events-calendar">
        <?php
        $refDateObj = new DateTime($homeCalRefDate);

        $moisFr = [
          '01' => 'JANVIER',
          '02' => 'FÉVRIER',
          '03' => 'MARS',
          '04' => 'AVRIL',
          '05' => 'MAI',
          '06' => 'JUIN',
          '07' => 'JUILLET',
          '08' => 'AOÛT',
          '09' => 'SEPTEMBRE',
          '10' => 'OCTOBRE',
          '11' => 'NOVEMBRE',
          '12' => 'DÉCEMBRE',
        ];

        $moisNum = $refDateObj->format('m');
        $nomMois = $moisFr[$moisNum] ?? strtoupper($refDateObj->format('F'));

        // jours du mois qui ont au moins un évènement
        $daysWithEvents = [];
        foreach ($homeCalEventsRaw as $ev) {
          $d   = new DateTime($ev['dateEvent']);
          $day = (int)$d->format('j');
          $daysWithEvents[$day] = true;
        }

        // navigation mois précédent / suivant
        $prevMonthObj = (clone $refDateObj)->modify('-1 month');
        $nextMonthObj = (clone $refDateObj)->modify('+1 month');

        $prevLink = '?page=accueil&month=' . $prevMonthObj->format('Y-m');
        $nextLink = '?page=accueil&month=' . $nextMonthObj->format('Y-m');

        $firstDay  = new DateTime($refDateObj->format('Y-m-01'));
        $monthInt  = (int)$firstDay->format('m');
        $dayOfWeek = (int)$firstDay->format('N'); // 1 = lundi
        ?>

        <div class="eg-home-cal-card">
          <div class="eg-home-cal-header">
            <a href="<?= htmlspecialchars($prevLink) ?>" class="eg-home-cal-nav">«</a>
            <div class="eg-home-cal-title">
              <span class="eg-home-cal-month"><?= $nomMois ?></span>
              <span class="eg-home-cal-year"><?= $refDateObj->format('Y') ?></span>
            </div>
            <a href="<?= htmlspecialchars($nextLink) ?>" class="eg-home-cal-nav">»</a>
          </div>

          <div class="eg-home-cal-weekdays">
            <span>lun.</span>
            <span>mar.</span>
            <span>mer.</span>
            <span>jeu.</span>
            <span>ven.</span>
            <span>sam.</span>
            <span>dim.</span>
          </div>

          <div class="eg-home-cal-days">
            <?php
            // cases vides avant le 1er
            for ($i = 1; $i < $dayOfWeek; $i++) {
              echo '<span class="eg-home-cal-day empty"></span>';
            }

            // jours du mois
            while ((int)$firstDay->format('m') === $monthInt) {
              $dayNum = (int)$firstDay->format('j');

              $classes = 'eg-home-cal-day';
              if (isset($daysWithEvents[$dayNum])) {
                $classes .= ' has-event';
              }

              echo '<span class="' . $classes . '">' . $dayNum . '</span>';
              $firstDay->modify('+1 day');
            }
            ?>
          </div>
        </div>
      </aside>

            <!-- ===== Liste des événements à droite ===== -->
      <div class="eg-home-events-right">
        <?php if (empty($homeEvents)): ?>
          <p class="eg-home-empty-text">Aucun évènement programmé pour ce mois.</p>
        <?php else: ?>
          <ul class="eg-home-events-list">
            <?php foreach ($homeEvents as $ev): ?>
              <?php
              $d          = new DateTime($ev['dateEvent']);
              $dateString = $d->format('Y-m-d');
              ?>
              <li class="eg-home-event-item">
                <a href="../Event/evenement.php?date=<?= urlencode($dateString) ?>" class="eg-home-event-link">
                  <div class="eg-home-event-date">
                    <span class="eg-home-event-day"><?= $d->format('d') ?></span>
                    <span class="eg-home-event-month"><?= $d->format('m') ?></span>
                  </div>
                  <div class="eg-home-event-content">
                    <div class="eg-home-event-title">
                      <?= htmlspecialchars($ev['nomEvent']) ?>
                    </div>
                    <div class="eg-home-event-sub">
                      <?= htmlspecialchars($ev['lieuEvent'] ?? 'Lieu à préciser') ?>
                    </div>
                  </div>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

        <div class="eg-home-events-btn-row">
          <a href="../event/evenement.php" class="eg-home-section-btn">
            Voir tous les évènements
          </a>
        </div>
      </div>


    </div>
  </section>

  <!-- ========= ACTUALITÉS ========= -->
  <section class="eg-home-news">
    <h2 class="eg-home-section-title">Actualités</h2>

    <?php if (empty($homeNews)): ?>
      <p class="eg-home-empty-text">Aucune actualité pour le moment.</p>
    <?php else: ?>
      <div class="eg-home-news-grid">
        <?php foreach ($homeNews as $news): ?>
          <?php
          $d = new DateTime($news['datePubCom']);
          $extrait = mb_substr($news['contenuCom'], 0, 140);
          if (mb_strlen($news['contenuCom']) > 140) {
            $extrait .= '…';
          }
          ?>
          <article class="eg-home-news-card">
            <h3 class="eg-home-news-title">
              <?= htmlspecialchars($news['titreCom']) ?>
            </h3>
            <p class="eg-home-news-meta">
              <?= $d->format('d/m/Y') ?>
              · <?= htmlspecialchars($news['nomTypeCom']) ?>
            </p>
            <p class="eg-home-news-excerpt">
              <?= nl2br(htmlspecialchars($extrait)) ?>
            </p>
            <a href="../Communication/com.php?id=<?= (int)$news['idCom'] ?>" class="eg-home-news-link">
              Voir l’article
            </a>
          </article>
        <?php endforeach; ?>
      </div>

      <div class="eg-home-news-btn-row">
        <a href="../Communication/pagecom.php" class="eg-home-section-btn">
          Voir toutes les actualités
        </a>
      </div>
    <?php endif; ?>
  </section>

</main>

<?php require __DIR__ . '/../Header Footer/footer.php'; ?>

</body>
</html>
