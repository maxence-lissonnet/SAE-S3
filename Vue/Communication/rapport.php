<?php require __DIR__ . '/../../Controller/Autre/HeaderController.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ÉcoGestUM - Rapports</title>
    <link rel="stylesheet" href="Asset/style/rapportStyle.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="Asset/js/pdfDownload.js"></script>
</head>

<body>

    <main class="container-rapport-page">

        <div class="header-titre">
            <h1>Rapports d'activité</h1>
            <p>Gestion et archivage des rapports de développement durable</p>
        </div>

        <div class="layout-rapport">

            <!-- ================= COLONNE GAUCHE : LISTE ================= -->
            <aside class="col-liste">
                <h2>Historique</h2>
                <div class="liste-rapports">
                    <a href="?page=rapport"
                        class="card-rapport-item <?php echo empty($_GET['edit']) ? 'active' : ''; ?> nouvelle-saisie">
                        <span class="icon">+</span>
                        <span>Nouveau rapport</span>
                    </a>

                    <?php if (empty($listOfReports)): ?>
                        <p class="empty-msg">Aucun rapport archivé.</p>
                    <?php else: ?>
                        <?php foreach ($listOfReports as $rap): ?>
                            <?php
                            $isActive = (isset($_GET['edit']) && $_GET['edit'] == $rap['idRapport']) ? 'active' : '';
                            $dateObj = new DateTime($rap['periodeRapport']);
                            $annee = $dateObj->format('Y');
                            $descCourt = !empty($rap['descRapport']) && $rap['descRapport'] !== 'Pas de contenu'
                                ? htmlspecialchars($rap['descRapport'])
                                : 'Rapport ' . $annee;
                            ?>
                            <a href="?page=rapport&edit=<?php echo $rap['idRapport']; ?>"
                                class="card-rapport-item <?php echo $isActive; ?>">
                                <div class="item-header">
                                    <span class="annee"><?php echo $annee; ?></span>
                                    <span class="date-creation">Créé le <?php echo $dateObj->format('d/m/Y'); ?></span>
                                </div>
                                <div class="item-desc"><?php echo $descCourt; ?></div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </aside>

            <!-- ================= COLONNE DROITE : FORMULAIRE / DETAILS ================= -->
            <section class="col-formulaire">
                <div class="card form-card">
                    <div class="form-header">
                        <h2>
                            <?php echo !empty($reportToEdit['idRapport']) ? 'Modifier un rapport' : 'Créer un rapport'; ?>
                        </h2>
                        <?php if (!empty($reportToEdit['idRapport'])): ?>
                            <div class="actions-header" data-html2pdf-ignore="true">
                                <button onclick="downloadPDF()" class="btn-pdf small">
                                    Télécharger PDF
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div id="report-container">

                        <div class="pdf-only-header" style="display:none;">
                            <h1>Rapport d'activité <?php echo $reportToEdit['periode']; ?></h1>
                            <p><?php echo htmlspecialchars($reportToEdit['descRapport']); ?></p>
                            <hr>
                        </div>

                        <form method="POST" class="form-rapport-complet">
                            <?php if (!empty($reportToEdit['idRapport'])): ?>
                                <input type="hidden" name="idRapport" value="<?php echo $reportToEdit['idRapport']; ?>">
                            <?php endif; ?>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Année concernée</label>
                                    <select name="annee">
                                        <?php
                                        $currentYear = date('Y');
                                        $selectedYear = $reportToEdit['periode'] ?? $currentYear;
                                        for ($y = $currentYear; $y >= $currentYear - 5; $y--):
                                            ?>
                                            <option value="<?php echo $y; ?>" <?php echo ($selectedYear == $y) ? 'selected' : ''; ?>>
                                                <?php echo $y; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="form-group flex-2">
                                    <label>Description</label>
                                    <input type="text" name="desc" maxlength="100"
                                        placeholder="Ex: Bilan carbone annuel..."
                                        value="<?php echo htmlspecialchars($reportToEdit['descRapport'] ?? ''); ?>">
                                </div>
                            </div>


                            <div class="preview-section">
                                <h3>Aperçu des données mensuelles</h3>
                                <table class="table small-table">
                                    <thead>
                                        <tr>
                                            <th>Mois</th>
                                            <th>Quantité</th>
                                            <th>Performance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($donnees_mois as $ligne): ?>
                                            <tr>
                                                <td><?php echo $ligne['mois']; ?></td>
                                                <td><?php echo $ligne['poids']; ?> kg</td>
                                                <td>
                                                    <div class="progress-bg">
                                                        <div class="progress-bar"
                                                            style="width: <?php echo $ligne['taux']; ?>%;"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-actions" data-html2pdf-ignore="true">
                                <button type="submit" name="save_metrics" class="btn btn-primary">
                                    <?php echo !empty($reportToEdit['idRapport']) ? 'Mettre à jour' : 'Enregistrer le rapport'; ?>
                                </button>

                                <?php if (!empty($reportToEdit['idRapport'])): ?>
                                    <button type="submit" name="delete_rapport" class="btn btn-danger"
                                        onclick="return confirm('Supprimer ce rapport ?');">
                                        Supprimer
                                    </button>
                                <?php endif; ?>
                            </div>

                        </form>
                    </div>

                </div>
            </section>

        </div>

    </main>

</body>

</html>