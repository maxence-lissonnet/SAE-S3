<?php require __DIR__ . '/../../Controller/Autre/HeaderController.php'; ?>
<?php

$chiffres_cles = [
    'poids_total' => 1250,      // Total kg
    'taux_recyclage' => 78,     // %
    'economie_co2' => 450,      // kg CO2
    'objets_revalorises' => 342 // Nb objets
];

// 2. Les données du tableau (Détail mensuel)
$donnees_mois = [
    ['mois' => 'Janvier', 'poids' => 200, 'taux' => 80],
    ['mois' => 'Février', 'poids' => 150, 'taux' => 70],
    ['mois' => 'Mars', 'poids' => 300, 'taux' => 90],
    ['mois' => 'Avril', 'poids' => 250, 'taux' => 75],
];

// Gestion simple du formulaire (juste pour l'exemple)
$annee = $_POST['annee'] ?? '2025';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ÉcoGestUM - Rapport</title>
    <link rel="stylesheet" href="Asset/style/rapportStyle.css">
</head>

<body>



    <div class="container">

        <div class="header-titre">
            <h1>Rapport d'activité</h1>
            [cite_start]<p>Suivi des objectifs de développement durable [cite: 104]</p>
        </div>

        <div class="card filtres">
            <form method="POST">
                <label>Période :</label>
                <select name="annee">
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                </select>
                <button type="submit" class="btn">Actualiser</button>
            </form>
        </div>

        <div class="grid-kpi">
            <div class="card kpi">
                <h3>Masse Recyclée</h3>
                <div class="valeur"><?php echo $chiffres_cles['poids_total']; ?> kg</div>
            </div>
            <div class="card kpi">
                <h3>Taux de Recyclage</h3>
                <div class="valeur bleu"><?php echo $chiffres_cles['taux_recyclage']; ?> %</div>
            </div>
            <div class="card kpi">
                <h3>CO2 Économisé</h3>
                <div class="valeur vert"><?php echo $chiffres_cles['economie_co2']; ?> kg</div>
            </div>
            <div class="card kpi">
                <h3>Objets Réutilisés</h3>
                <div class="valeur"><?php echo $chiffres_cles['objets_revalorises']; ?></div>
            </div>
        </div>

        <div class="card">
            <h2>Détail mensuel</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Mois</th>
                        <th>Quantité (kg)</th>
                        <th>Performance</th>
                        <th>Taux</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($donnees_mois as $ligne): ?>
                        <tr>
                            <td><?php echo $ligne['mois']; ?></td>
                            <td><?php echo $ligne['poids']; ?> kg</td>
                            <td>
                                <div class="progress-bg">
                                    <div class="progress-bar" style="width: <?php echo $ligne['taux']; ?>%;"></div>
                                </div>
                            </td>
                            <td><?php echo $ligne['taux']; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="margin-top: 15px; text-align: right;">
                <a href="#" class="btn-outline">Télécharger le PDF</a>
            </div>
        </div>

    </div>

</body>

</html>




<?php require __DIR__ . '/../../Controller/Autre/HeaderController.php'; ?>