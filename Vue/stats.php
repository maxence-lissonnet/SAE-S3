<?php
include '../Model/model.php';
include 'header.php';
?>

<link rel="stylesheet" href="/SAE-S3/Asset/style/statsstyle.css">

<?php
// Récupérer les 3 dernières statistiques
$pdo = get_dtb();
$requete = "
    SELECT idStat, titreStat, contenuStat, imageStat, dateCreaStat, idTypeStatistique
    FROM STATISTIQUE
    ORDER BY dateCreaStat DESC, idStat DESC
    LIMIT 3
";

$result = $pdo->query($requete);
$stats = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
  <h1>Statistiques</h1>

  <?php if (count($stats) > 0): ?>
    <div class="stats-container">
      <?php foreach ($stats as $index => $stat): ?>
        <div class="stat-card">
          <div class="stat-image-container">
            <?php if (!empty($stat['imageStat'])): ?>
              <img 
                src="data:image/jpeg;base64,<?php echo base64_encode($stat['imageStat']); ?>" 
                alt="<?php echo htmlspecialchars($stat['titreStat']); ?>" 
                class="stat-image"
              >
            <?php else: ?>
              <div style="display: flex; align-items: center; justify-content: center; color: #ccc; height: 100%; font-size: 14px;">
                Pas d'image
              </div>
            <?php endif; ?>
          </div>

          <div class="stat-text-content">
            <h2 class="stat-title"><?php echo htmlspecialchars($stat['titreStat']); ?></h2>
            
            <p class="stat-content">
              <?php echo htmlspecialchars($stat['contenuStat']); ?>
            </p>

            <div class="stat-date">
              📅 <?php echo date('d/m/Y', strtotime($stat['dateCreaStat'])); ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="no-stats">
      <h2>Aucune statistique disponible</h2>
      <p>Les statistiques seront affichées ici une fois qu'elles seront créées.</p>
    </div>
  <?php endif; ?>
</main>

<?php
include 'footer.php';
?>
