<link rel="stylesheet" href="Asset/style/notificationstyle.css">
<?php require __DIR__ . '/../../Controller/Autre/HeaderController.php'; ?>

<main class="eg-notif-page">

  <h1 class="eg-notif-title">Notifications</h1>
  <p class="eg-notif-subtitle">
    <?= $unreadCount ?> non lues – <?= $totalCount ?> au total<br>
    <span class="eg-notif-sub-sub">Cliquez sur une notification pour la lire.</span>
  </p>

  <section class="eg-notif-layout">

    <!-- =================== COLONNE GAUCHE =================== -->
    <aside class="eg-notif-list-panel">

      <!-- Onglets boîte de réception / archivées -->
      <div class="eg-notif-tabs">
        <a href="Notifications?box=inbox" class="eg-notif-tab <?= $box === 'inbox' ? 'is-active' : '' ?>">
          Boîte de réception
        </a>
        <a href="Notifications?box=archive" class="eg-notif-tab <?= $box === 'archive' ? 'is-active' : '' ?>">
          Archivées
        </a>
      </div>

      <div class="eg-notif-list">
        <?php if (empty($notifications)): ?>
          <p class="eg-notif-empty">Aucune notification dans cette boîte.</p>
        <?php else: ?>
          <?php foreach ($notifications as $notif): ?>
            <?php $isActive = ($currentNotif && $notif['id'] === $currentNotif['id']); ?>
            <a href="Notifications?box=<?= htmlspecialchars($box) ?>&id=<?= (int) $notif['id'] ?>"
              class="eg-notif-item <?= $isActive ? 'is-active' : '' ?>">
              <div class="eg-notif-dot <?= $notif['isUnread'] ? 'is-unread' : '' ?>"></div>

              <div class="eg-notif-item-content">
                <div class="eg-notif-item-title">
                  <?= htmlspecialchars($notif['titre']) ?>
                </div>
                <div class="eg-notif-item-source">
                  <?= htmlspecialchars($notif['source']) ?>
                </div>
                <div class="eg-notif-item-date">
                  <?= htmlspecialchars($notif['dateTxt']) ?>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </aside>

    <!-- =================== COLONNE DROITE =================== -->
    <section class="eg-notif-detail-panel">

      <?php if ($currentNotif): ?>
        <!-- Barres d’avertissement (cachées au départ) -->
        <div id="notifDeleteBar" class="eg-notif-bar eg-notif-bar--danger" hidden>
          <span>Voulez-vous vraiment supprimer cette notification ?</span>
          <div class="eg-notif-bar-actions">
            <button type="button" class="eg-notif-bar-btn" data-bar-action="cancel">Non</button>
            <button type="button" class="eg-notif-bar-btn eg-notif-bar-btn--yes"
              data-bar-action="confirm-delete">Oui</button>
          </div>
        </div>

        <div id="notifArchiveBar" class="eg-notif-bar eg-notif-bar--warning" hidden>
          <span>
            <?= $box === 'archive'
              ? 'Voulez-vous vraiment désarchiver cette notification ?'
              : 'Voulez-vous vraiment archiver cette notification ?' ?>
          </span>
          <div class="eg-notif-bar-actions">
            <button type="button" class="eg-notif-bar-btn" data-bar-action="cancel">Non</button>
            <button type="button" class="eg-notif-bar-btn eg-notif-bar-btn--yes"
              data-bar-action="confirm-archive">Oui</button>
          </div>
        </div>

        <!-- Actions -->
        <div class="eg-notif-actions">
          <button type="button" id="btnNotifDelete" class="eg-notif-action">
            🗑️ <span>Supprimer</span>
          </button>

          <button type="button" class="eg-notif-action" disabled>
            📌 <span>Épingler</span>
          </button>

          <button type="button" id="btnNotifArchive" class="eg-notif-action">
            📁 <span><?= $box === 'archive' ? 'Désarchiver' : 'Archiver' ?></span>
          </button>
        </div>

        <!-- Carte de notification -->
        <!-- Carte de notification -->
        <article class="eg-notif-card">
          <header class="eg-notif-card-header">
            <h2 class="eg-notif-card-title">
              <?= htmlspecialchars($currentNotif['detailTitre']) ?>
            </h2>
            <p class="eg-notif-card-source">
              <?= htmlspecialchars($currentNotif['source']) ?>
            </p>
            <p class="eg-notif-card-date">
              <?= htmlspecialchars($currentNotif['dateTxt']) ?>
            </p>
          </header>

          <hr class="eg-notif-card-separator">

          <p class="eg-notif-card-text">
            <?= nl2br(htmlspecialchars($currentNotif['detailTexte'])) ?>
          </p>

          <?php if (!empty($currentNotif['canReserve'])): ?>
            <div class="eg-notif-card-main-action">
              <button type="button" class="eg-notif-main-btn">
                Réserver
              </button>
            </div>

            <p class="eg-notif-card-footnote">
              Ce don permet d’éviter 330 kg de CO₂.
            </p>
          <?php endif; ?>
        </article>



        <!-- Formulaires cachés pour POST -->
        <form id="notifDeleteForm" method="post" style="display:none;">
          <input type="hidden" name="notif_id" value="<?= (int) $currentNotif['id'] ?>">
          <input type="hidden" name="action" value="delete">
        </form>

        <form id="notifArchiveForm" method="post" style="display:none;">
          <input type="hidden" name="notif_id" value="<?= (int) $currentNotif['id'] ?>">
          <input type="hidden" name="action" value="<?= $box === 'archive' ? 'unarchive' : 'archive' ?>">
        </form>

      <?php else: ?>

        <p class="eg-notif-empty-detail">Aucune notification à afficher.</p>

      <?php endif; ?>

    </section>

  </section>

</main>

<?php require __DIR__ . '/../Header Footer/footer.php'; ?>

<script src="../../Asset/js/notif.js"></script>
</body>

</html>