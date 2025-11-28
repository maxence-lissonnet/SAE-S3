<?php
// Vue/pagecom.php

require_once __DIR__ . '/../../Controller/Com/ComController.php';

// Sécurisation au cas où
$comList   = $comList   ?? [];
$typesCom  = $typesCom  ?? [];
$idTypeCom = $idTypeCom ?? null;
$dateCom   = $dateCom   ?? null;
?>
<link rel="stylesheet" href="../../Asset/style/pagecomstyle.css">
<?php require __DIR__ . '/../Header Footer/header.php'; ?>

<main class="eg-com-page">

  <h1 class="eg-com-title">Communication</h1>
  <p class="eg-com-subtitle">Cliquez sur une publication pour la lire.</p>

  <section class="eg-com-layout">

    <!-- ====== COLONNE GAUCHE : LISTE ====== -->
    <section class="eg-com-list">
      <?php if (empty($comList)): ?>
        <p>Aucune communication ne correspond à vos filtres.</p>
      <?php else: ?>
        <?php foreach ($comList as $com): ?>
          <article class="eg-com-item">
            <a href="com.php?id=<?= (int)$com['idCom'] ?>" class="eg-com-item-main">
              <div class="eg-com-thumb">
                <!-- on met juste un fond gris pour rappeler la maquette -->
                <div class="eg-com-thumb-circle"></div>
              </div>
              <div class="eg-com-item-text">
                <h2 class="eg-com-item-title">
                  <?= htmlspecialchars($com['titreCom']) ?>
                </h2>
                <div class="eg-com-item-meta">
                  <?php
                  $d = new DateTime($com['datePubCom']);
                  echo htmlspecialchars($d->format('H:i')) . ' – ' . htmlspecialchars($d->format('d/m/Y'));
                  ?>
                  &nbsp;·&nbsp;
                  <?= htmlspecialchars($com['nomTypeCom']) ?>
                </div>
                <p class="eg-com-item-excerpt">
                  <?= htmlspecialchars(mb_strimwidth($com['contenuCom'], 0, 150, '…', 'UTF-8')) ?>
                </p>
              </div>
            </a>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </section>

    <!-- ====== COLONNE DROITE : BOUTON + FILTRES ====== -->
    <aside class="eg-com-sidebar">

      <div class="eg-com-publish-block">
        <span class="eg-com-publish-label">Publier</span>
        <a href="ajoucom.php" class="eg-btn-publish">Créer une publication</a>
      </div>

      <h2 class="eg-com-filter-title">Filtrer par</h2>

      <form method="get" action="pagecom.php" class="eg-com-filter-form">

        <label class="eg-field-group">
          <span>Type de publication</span>
          <select name="type">
            <option value="">Tous les types</option>
            <?php foreach ($typesCom as $type): ?>
              <option value="<?= $type['idTypeCom'] ?>"
                <?= ($idTypeCom === (int)$type['idTypeCom']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($type['nomTypeCom']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </label>

        <label class="eg-field-group">
          <span>Date</span>
          <input type="text"
                 name="date"
                 placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ"
                 value="<?= htmlspecialchars($dateCom ?? '') ?>">
        </label>

        <div class="eg-com-filter-actions">
          <button type="submit" class="eg-btn-main">Appliquer les filtres</button>
          <button type="submit" name="reset" value="1" class="eg-btn-secondary">
            Supprimer les filtres
          </button>
        </div>

      </form>
    </aside>

  </section>
</main>


<?php require __DIR__ . '/../Header Footer/footer.php'; ?>
