<link rel="stylesheet" href="../../Asset/style/eventstyle.css">
<?php require __DIR__ . '/../../Controller/Autre/HeaderController.php'; ?>

<main class="eg-event-page">

    <h1 class="eg-event-title">Évènements</h1>

    <section class="eg-event-layout">

        <!-- ================== COLONNE GAUCHE : CALENDRIER ================== -->
        <aside class="eg-event-calendar">
            <div class="eg-event-month-card">
                <?php
                // On utilise maintenant la date fournie par le contrôleur
                $refDateObj = new DateTime($calendarRefDate);

                // Noms de mois en français
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

                // Jours du mois qui ont au moins un évènement (basé sur $eventsCalendar)
                $daysWithEvents = [];
                foreach ($eventsCalendar as $ev) {
                    $d = new DateTime($ev['dateEvent']);
                    $day = (int)$d->format('j');
                    $daysWithEvents[$day] = true;
                }

                // Liens pour changer de mois (on garde les filtres type/lieu, mais on reset la date)
                $prevMonthObj = (clone $refDateObj)->modify('-1 month');
                $nextMonthObj = (clone $refDateObj)->modify('+1 month');

                $baseFilters = '';
                if (!empty($idTypeEvent)) {
                    $baseFilters .= '&type=' . (int)$idTypeEvent;
                }
                if (!empty($lieuSearch)) {
                    $baseFilters .= '&lieu=' . urlencode($lieuSearch);
                }

                $prevLink = '?page=evenement&month=' . $prevMonthObj->format('Y-m') . $baseFilters;
                $nextLink = '?page=evenement&month=' . $nextMonthObj->format('Y-m') . $baseFilters;
                ?>

                <div class="eg-event-month-header">
                    <a href="<?= htmlspecialchars($prevLink) ?>" class="eg-event-month-nav">&laquo;</a>
                    <div>
                        <span class="eg-event-month-name"><?= $nomMois ?></span>
                        <span class="eg-event-month-year"><?= $refDateObj->format('Y') ?></span>
                    </div>
                    <a href="<?= htmlspecialchars($nextLink) ?>" class="eg-event-month-nav">&raquo;</a>
                </div>

                <div class="eg-event-weekdays">
                    <span>lun.</span>
                    <span>mar.</span>
                    <span>mer.</span>
                    <span>jeu.</span>
                    <span>ven.</span>
                    <span>sam.</span>
                    <span>dim.</span>
                </div>

                <div class="eg-event-days">
                    <?php
                    // On positionne le 1er jour du mois sur la bonne colonne
                    $firstDay  = new DateTime($refDateObj->format('Y-m-01'));
                    $month     = (int)$firstDay->format('m');
                    $dayOfWeek = (int)$firstDay->format('N'); // 1 = lundi

                    // Cases vides avant le 1er
                    for ($i = 1; $i < $dayOfWeek; $i++) {
                        echo '<span class="eg-event-day empty"></span>';
                    }

                    // Jours du mois
                    while ((int)$firstDay->format('m') === $month) {
                        $dayNum  = (int)$firstDay->format('j');
                        $dayDate = $firstDay->format('Y-m-d');

                        $classes = 'eg-event-day';
                        if (isset($daysWithEvents[$dayNum])) {
                            $classes .= ' has-event';
                        }

                        // Cliquer sur le jour filtre la liste par date
                        $href = '?page=evenement&date=' . $dayDate;
                        echo '<a href="' . htmlspecialchars($href) . '" class="' . $classes . '">' . $dayNum . '</a>';

                        $firstDay->modify('+1 day');
                    }
                    ?>
                </div>
            </div>
        </aside>

        <!-- ================== COLONNE CENTRALE : LISTE BLEUE ================== -->
        <section class="eg-event-list">
            <div class="eg-event-list-card">
                <?php if (empty($events)): ?>
                    <p class="eg-event-empty">Aucun évènement ne correspond à vos filtres.</p>
                <?php else: ?>
                    <?php foreach ($events as $event): ?>
                        <article class="eg-event-item">
                            <header class="eg-event-item-header">
                                <div>
                                    <h2 class="eg-event-item-title">
                                        <?= htmlspecialchars($event['nomEvent']) ?>
                                    </h2>
                                    <div class="eg-event-item-subtitle">
                                        <?= htmlspecialchars($event['lieuEvent'] ?? 'Lieu à préciser') ?>
                                    </div>
                                </div>
                                <div class="eg-event-item-type">
                                    <?= htmlspecialchars($event['nomTypeEvent']) ?>
                                </div>
                            </header>

                            <div class="eg-event-item-date">
                                <?php
                                $d = new DateTime($event['dateEvent']);
                                echo $d->format('d/m/Y');
                                ?>
                                &nbsp; · &nbsp;
                                <?= substr($event['heureDebEvent'], 0, 5) ?>
                                <?php if (!empty($event['heureFinEvent'])): ?>
                                    – <?= substr($event['heureFinEvent'], 0, 5) ?>
                                <?php endif; ?>
                            </div>

                            <p class="eg-event-item-desc">
                                <?= nl2br(htmlspecialchars($event['descEvent'])) ?>
                            </p>

                            <div class="eg-event-item-actions">
                                <!-- Lien pour charger l'évènement dans le formulaire de droite -->
                                <a href="?page=evenement&edit=<?= (int)$event['idEvent'] ?>"
                                   class="eg-btn-link">
                                    Modifier / détails
                                </a>
                            </div>
                        </article>

                        <hr class="eg-event-separator">
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- ================== COLONNE DROITE : FILTRES + FORMULAIRE ================== -->
        <aside class="eg-event-filters">
            <h2>Filtrer par</h2>

            <form method="get" class="eg-event-filter-form">
                <input type="hidden" name="page" value="evenement">

                <label class="eg-field-group">
                    <span>Type</span>
                    <select name="type">
                        <option value="">Tous les types</option>
                        <?php foreach ($typesEvenement as $type): ?>
                            <option value="<?= $type['idTypeEvent'] ?>"
                                <?= ($idTypeEvent === (int)$type['idTypeEvent']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($type['nomTypeEvent']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label class="eg-field-group">
                    <span>Date</span>
                    <input type="text"
                           name="date"
                           placeholder="AAAA, AAAA-MM ou AAAA-MM-JJ"
                           value="<?= htmlspecialchars($dateEvent ?? '') ?>">
                </label>

                <label class="eg-field-group">
                    <span>Lieu</span>
                    <input type="text" name="lieu"
                           placeholder="Campus, bâtiment..."
                           value="<?= htmlspecialchars($lieuSearch ?? '') ?>">
                </label>

                <div class="eg-event-filter-actions">
                    <button type="submit" class="eg-btn-main">
                        Appliquer les filtres
                    </button>

                    <button type="submit" name="reset" value="1" class="eg-btn-secondary">
                        Supprimer les filtres
                    </button>
                </div>
            </form>

            <hr class="eg-event-divider">

            <!-- ========= FORMULAIRE CREATION / MODIFICATION ========= -->
            <h2>
                <?= isset($eventToEdit['idEvent']) ? 'Modifier un évènement' : 'Créer un évènement' ?>
            </h2>

            <?php if (!empty($formErrors)): ?>
                <ul class="eg-form-errors">
                    <?php foreach ($formErrors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <!-- Formulaire principal : création / édition -->
                        <!-- ========= FORMULAIRE CREATION / MODIFICATION ========= -->
            <h2>
                <?= isset($eventToEdit['idEvent']) ? 'Modifier un évènement' : 'Créer un évènement' ?>
            </h2>

            <?php if (!empty($formErrors)): ?>
                <ul class="eg-form-errors">
                    <?php foreach ($formErrors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <!-- Formulaire principal : création / édition -->
            <form method="post" class="eg-event-edit-form" id="validateForm">
                <?php if (!empty($eventToEdit['idEvent'])): ?>
                    <input type="hidden" name="idEvent"
                           value="<?= (int)$eventToEdit['idEvent'] ?>">
                <?php endif; ?>

                <label class="eg-field-group">
                    <span>Nom de l'évènement</span>
                    <input type="text" name="nomEvent"
                           value="<?= htmlspecialchars($eventToEdit['nomEvent'] ?? '') ?>">
                </label>

                <label class="eg-field-group">
                    <span>Type</span>
                    <select name="idTypeEvent">
                        <option value="">-- choisir --</option>
                        <?php foreach ($typesEvenement as $type): ?>
                            <?php
                            $selected = '';
                            if (!empty($eventToEdit['idTypeEvent']) &&
                                (int)$eventToEdit['idTypeEvent'] === (int)$type['idTypeEvent']) {
                                $selected = 'selected';
                            }
                            ?>
                            <option value="<?= $type['idTypeEvent'] ?>" <?= $selected ?>>
                                <?= htmlspecialchars($type['nomTypeEvent']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label class="eg-field-group">
                    <span>Date</span>
                    <input type="date" name="dateEvent"
                           value="<?= htmlspecialchars($eventToEdit['dateEvent'] ?? '') ?>">
                </label>

                <label class="eg-field-group">
                    <span>Heure début</span>
                    <input type="time" name="heureDebEvent"
                           value="<?= htmlspecialchars($eventToEdit['heureDebEvent'] ?? '') ?>">
                </label>

                <label class="eg-field-group">
                    <span>Heure fin (optionnel)</span>
                    <input type="time" name="heureFinEvent"
                           value="<?= htmlspecialchars($eventToEdit['heureFinEvent'] ?? '') ?>">
                </label>

                <label class="eg-field-group">
                    <span>Lieu</span>
                    <input type="text" name="lieuEvent"
                           value="<?= htmlspecialchars($eventToEdit['lieuEvent'] ?? '') ?>">
                </label>

                <label class="eg-field-group">
                    <span>Description</span>
                    <textarea name="descEvent" rows="4"><?= htmlspecialchars($eventToEdit['descEvent'] ?? '') ?></textarea>
                </label>

                <div class="eg-event-edit-actions">
                    <!-- IMPORTANT : type="button" pour laisser JS gérer la soumission -->
                    <button type="button"
                            id="validateButton"
                            name="save"
                            value="1"
                            class="eg-btn-main">
                        <?= isset($eventToEdit['idEvent']) ? 'Mettre à jour' : 'Créer l\'évènement' ?>
                    </button>

                    <?php if (isset($eventToEdit['idEvent'])): ?>
                        <!-- bouton cliqué → ouverture popup JS de suppression -->
                        <button type="button"
                                id="eventDeleteButton"
                                class="eg-btn-danger">
                            Supprimer
                        </button>
                    <?php endif; ?>
                </div>
            </form>

            <?php if (isset($eventToEdit['idEvent'])): ?>
                <!-- Formulaire caché uniquement pour la suppression -->
                <form id="eventDeleteForm" method="post" style="display:none;">
                    <input type="hidden" name="idEvent" value="<?= (int)$eventToEdit['idEvent'] ?>">
                    <input type="hidden" name="delete" value="1">
                </form>
            <?php endif; ?>

        </aside>

    </section>
</main>

<?php require __DIR__ . '/../Header Footer/footer.php'; ?>

</body>
</html>

