<title>Statistiques - EcoGestUM</title>

<link rel="stylesheet" href="Asset/style/statsstyle.css">

<?php
require_once __DIR__ . '/../../Controller/Autre/HeaderController.php';
$stats = getLastThreeStats();
?>

<main>
    <div style="display: flex; gap: 10px; margin-bottom: 20px;">
        <img src="Asset/image/header/graph.png" alt="Icone statistiques" style="width: 50px; height: 50px;">
        <h1 style="margin: 0;">Statistiques</h1>
    </div>

    <?php if (count($stats) > 0): ?>
        <div class="stats-container">
            <?php foreach ($stats as $index => $stat): ?>
                <div class="stat-card">
                    <div class="stat-image-container">
                        <?php if (!empty($stat['imageStat'])): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($stat['imageStat']); ?>"
                                alt="<?php echo htmlspecialchars($stat['titreStat']); ?>" class="stat-image">
                        <?php else: ?>
                            <div
                                style="display: flex; align-items: center; justify-content: center; color: #ccc; height: 100%; font-size: 14px;">
                                Pas d'image
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="stat-text-content">
                        <h2 class="stat-title">
                            <?php echo htmlspecialchars($stat['titreStat']); ?>
                        </h2>

                        <p class="stat-content">
                            <?php echo htmlspecialchars($stat['contenuStat']); ?>
                        </p>

                        <div class="stat-date">
                            📅
                            <?php echo date('d/m/Y', strtotime($stat['dateCreaStat'])); ?>
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
include __DIR__ . '/../Header Footer/footer.php';
?>