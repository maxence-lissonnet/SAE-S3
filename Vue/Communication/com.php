<?php
// Vue/com.php
require_once __DIR__ . '/../../Controller/PageComController.php';
$com = $com ?? null;
?>
<link rel="stylesheet" href="../../Asset/style/comstyle.css">
<?php require __DIR__ . '/../Header Footer/header.php'; ?>

<main class="eg-com-full-page">

  <a href="pagecom.php" class="eg-back-btn">
    ← Retour aux communications
  </a>

  <?php if (!$com): ?>

    <div class="eg-com-full-container">
      <p>Communication introuvable.</p>
      <p>
        <a href="pagecom.php" class="eg-btn-secondary">
          Retour aux communications
        </a>
      </p>
    </div>

  <?php else: ?>

    <div class="eg-com-full-container">

      <header class="eg-com-full-header">
        <div>
          <h1 class="eg-com-full-title">
            <?= htmlspecialchars($com['titreCom']) ?>
          </h1>
          <p class="eg-com-full-meta">
            publié à
            <?= htmlspecialchars(substr($com['heurePubCom'], 0, 5)) ?>
            –
            <?php
            $d = new DateTime($com['datePubCom']);
            echo htmlspecialchars($d->format('d/m/Y'));
            ?>
            · <?= htmlspecialchars($com['nomTypeCom']) ?>
          </p>
        </div>

        <div class="eg-com-full-actions">
          <!-- Bouton "Modifier" dans le style des autres boutons principaux -->
          <a href="ajoucom.php?id=<?= (int)$com['idCom'] ?>"
             class="eg-com-action-btn eg-com-action-primary">
            Modifier
          </a>

          <!-- Bouton "Supprimer" dans le style des boutons secondaires -->
          <form id="deleteForm"
                class="eg-com-delete-form"
                method="post"
                action="com.php?id=<?= (int)$com['idCom'] ?>">
            <input type="hidden" name="idCom" value="<?= (int)$com['idCom'] ?>">
            <input type="hidden" name="delete" value="1">
            <button type="button"
                    id="deleteButton"
                    class="eg-com-action-btn eg-com-action-secondary">
              Supprimer
            </button>
          </form>
        </div>
      </header>

      <section class="eg-com-full-body">
        <article class="eg-com-full-article">
          <?= nl2br(htmlspecialchars($com['contenuCom'])) ?>
        </article>

        <aside class="eg-com-full-side">
          <!-- Illustration (pour l’instant, juste un bloc stylé) -->
          <div class="eg-com-full-illustration"></div>
        </aside>
      </section>

    </div>

  <?php endif; ?>

</main>

<?php require __DIR__ . '/../Header Footer/footer.php'; ?>

</body>
</html>
