<?php
// Vue/Communication/com.php
$com = $com ?? null;
?>
<title>Communication - EcoGestUM</title>

<link rel="stylesheet" href="Asset/style/comstyle.css">
<?php require __DIR__ . '/../../Controller/Autre/HeaderController.php'; ?>

<main class="eg-com-full-page">

  <a href="?page=Communication" class="eg-back-btn">
    ← Retour aux communications
  </a>

  <?php if (!$com): ?>

    <div class="eg-com-full-container">
      <p>Communication introuvable.</p>
      <p>
        <a href="?page=Communication" class="eg-btn-secondary">Retour aux communications</a>
      </p>
    </div>

  <?php else: ?>

    <div class="eg-com-full-container">

      <header class="eg-com-full-header">
        <div>
          <h1 class="eg-com-full-title"><?= htmlspecialchars($com['titreCom']) ?></h1>
          <p class="eg-com-full-meta">
            publié à <?= htmlspecialchars(substr($com['heurePubCom'], 0, 5)) ?> –
            <?php
            $d = new DateTime($com['datePubCom']);
            echo htmlspecialchars($d->format('d/m/Y'));
            ?>
            · <?= htmlspecialchars($com['nomTypeCom']) ?>
          </p>
        </div>

        <div class="eg-com-full-actions">
          <a href="?page=AjoutCom&idCom=<?= (int)$com['idCom'] ?>"
            class="eg-com-action-btn eg-com-action-primary">
            Modifier
          </a>

          <form id="deleteForm"
            class="eg-com-delete-form"
            method="post"
            action="?page=DetailCommunication&id=<?= (int)$com['idCom'] ?>">
            <input type="hidden" name="idCom" value="<?= (int)$com['idCom'] ?>">
            <input type="hidden" name="delete" value="1">
            <button type="button" id="deleteButton"
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
          <div class="eg-com-full-illustration"></div>
        </aside>
      </section>

    </div>

  <?php endif; ?>

</main>

<?php require __DIR__ . '/../Header Footer/footer.php'; ?>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('deleteButton');
    const form = document.getElementById('deleteForm');
    if (btn && form) {
      btn.addEventListener('click', () => {
        if (confirm('Supprimer cette communication ?')) {
          form.submit();
        }
      });
    }
  });
</script>

</body>

</html>