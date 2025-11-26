<?php
// Model/modEven.php

/**
 * Connexion PDO à la base EcoGestUM
 */

function getPDO(): PDO
{
    $host    = 'localhost';
    $db      = 'EcoGestUM';
    $user    = 'root';      // adapte si besoin
    $pass    = '';          // adapte si besoin
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    return new PDO($dsn, $user, $pass, $options);
}

/**
 * Tous les types d'évènements (pour les listes déroulantes).
 */
function getAllEventTypes(): array
{
    $pdo = getPDO();
    $sql = "SELECT idTypeEvent, nomTypeEvent
            FROM TYPE_EVENEMENT
            ORDER BY nomTypeEvent";
    return $pdo->query($sql)->fetchAll();
}

/**
 * Filtre sur type / date partielle / lieu (LIKE).
 * $dateFilter peut être :
 *   - "2025"        -> tous les évènements de 2025
 *   - "2025-11"     -> tous les évènements de nov. 2025
 *   - "2025-11-15"  -> ce jour précis
 */
function getEventsFiltered(?int $idTypeEvent, ?string $dateFilter, ?string $lieuSearch): array
{
    $pdo = getPDO();

    $sql = "SELECT evenement.idEvent, evenement.nomEvent, evenement.descEvent, evenement.dateEvent,
                   evenement.lieuEvent, evenement.heureDebEvent, evenement.heureFinEvent, type_evenement.nomTypeEvent,
                   evenement.idTypeEvent
            FROM EVENEMENT
            JOIN TYPE_EVENEMENT  ON type_evenement.idTypeEvent = evenement.idTypeEvent
            WHERE 1";
    $params = [];

    // filtre type
    if (!empty($idTypeEvent)) {
        $sql .= " AND evenement.idTypeEvent = :idTypeEvent";
        $params[':idTypeEvent'] = $idTypeEvent;
    }

    // filtre date partielle
    if (!empty($dateFilter)) {
        $dateFilter = trim($dateFilter);

        if (preg_match('#^\d{4}$#', $dateFilter)) {
            // année
            $sql .= " AND YEAR(evenement.dateEvent) = :year";
            $params[':year'] = $dateFilter;

        } elseif (preg_match('#^\d{4}-\d{2}$#', $dateFilter)) {
            // année-mois
            $sql .= " AND e.dateEvent BETWEEN :d1 AND :d2";
            $params[':d1'] = $dateFilter . '-01';
            $params[':d2'] = $dateFilter . '-31';

        } elseif (preg_match('#^\d{4}-\d{2}-\d{2}$#', $dateFilter)) {
            // date complète
            $sql .= " AND evenement.dateEvent = :dExact";
            $params[':dExact'] = $dateFilter;

        } else {
            // fallback : LIKE sur le début de la date
            $sql .= " AND e.dateEvent LIKE :dLike";
            $params[':dLike'] = $dateFilter . '%';
        }
    }

    // filtre lieu
    if (!empty($lieuSearch)) {
        $sql .= " AND evenement.lieuEvent LIKE :lieu";
        $params[':lieu'] = '%' . $lieuSearch . '%';
    }

    $sql .= " ORDER BY evenement.dateEvent, evenement.heureDebEvent";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Dates d'évènements pour un mois donné (pour le calendrier).
 * $yearMonth doit être au format "YYYY-MM".
 * On applique éventuellement les filtres type / lieu.
 */
function getEventsForMonth(string $yearMonth, ?int $idTypeEvent, ?string $lieuSearch): array
{
    $pdo = getPDO();

    $sql = "SELECT DISTINCT evenement.dateEvent
            FROM EVENEMENT 
            JOIN TYPE_EVENEMENT ON type_evenement.idTypeEvent = evenement.idTypeEvent
            WHERE evenement.dateEvent BETWEEN :d1 AND :d2";
    $params = [
        ':d1' => $yearMonth . '-01',
        ':d2' => $yearMonth . '-31',
    ];

    // filtre type (optionnel)
    if (!empty($idTypeEvent)) {
        $sql .= " AND evenement.idTypeEvent = :idTypeEvent";
        $params[':idTypeEvent'] = $idTypeEvent;
    }

    // filtre lieu (optionnel)
    if (!empty($lieuSearch)) {
        $sql .= " AND evenement.lieuEvent LIKE :lieu";
        $params[':lieu'] = '%' . $lieuSearch . '%';
    }

    $sql .= " ORDER BY evenement.dateEvent";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Un évènement par son id (pour pré-remplir le formulaire).
 */
function getEventById(int $idEvent): ?array
{
    $pdo = getPDO();
    $sql = "SELECT evenement.idEvent, evenement.nomEvent, evenement.descEvent, evenement.dateEvent,
            evenement.lieuEvent, evenement.heureDebEvent, evenement.heureFinEvent, evenement.idTypeEvent
            FROM EVENEMENT 
            WHERE evenement.idEvent = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $idEvent]);
    $row = $stmt->fetch();
    return $row ?: null;
}

/**
 * Création d'un évènement.
 * Retourne l'id créé.
 */
function insertEvent(array $data): int
{
    $pdo = getPDO();
    $sql = "INSERT INTO EVENEMENT
              (nomEvent, descEvent, dateEvent, lieuEvent,
               heureDebEvent, heureFinEvent, idTypeEvent)
            VALUES
              (:nom, :descr, :date, :lieu, :hDeb, :hFin, :type)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom'   => $data['nomEvent'],
        ':descr' => $data['descEvent'] ?? 'Pas de contenu',
        ':date'  => $data['dateEvent'],
        ':lieu'  => $data['lieuEvent'] ?? null,
        ':hDeb'  => $data['heureDebEvent'],
        ':hFin'  => $data['heureFinEvent'] ?: null,
        ':type'  => $data['idTypeEvent'],
    ]);
    return (int)$pdo->lastInsertId();
}

/**
 * Mise à jour d'un évènement existant.
 */
function updateEvent(int $idEvent, array $data): void
{
    $pdo = getPDO();
    $sql = "UPDATE EVENEMENT
            SET nomEvent      = :nom,
                descEvent     = :descr,
                dateEvent     = :date,
                lieuEvent     = :lieu,
                heureDebEvent = :hDeb,
                heureFinEvent = :hFin,
                idTypeEvent   = :type
            WHERE idEvent = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom'   => $data['nomEvent'],
        ':descr' => $data['descEvent'] ?? 'Pas de contenu',
        ':date'  => $data['dateEvent'],
        ':lieu'  => $data['lieuEvent'] ?? null,
        ':hDeb'  => $data['heureDebEvent'],
        ':hFin'  => $data['heureFinEvent'] ?: null,
        ':type'  => $data['idTypeEvent'],
        ':id'    => $idEvent,
    ]);
}

/**
 * Suppression d’un évènement.
 */
function deleteEvent(int $idEvent): void
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM EVENEMENT WHERE idEvent = :id");
    $stmt->execute([':id' => $idEvent]);
}
/**
 * Prochains évènements (pour l’accueil).
 * $limit = nombre d’évènements à retourner.
 */
function getNextEvents(int $limit = 2): array
{
    $pdo = getPDO();

    $sql = "SELECT
                e.idEvent,
                e.nomEvent,
                e.dateEvent,
                e.lieuEvent
            FROM EVENEMENT e
            WHERE e.dateEvent >= CURDATE()
            ORDER BY e.dateEvent, e.heureDebEvent
            LIMIT :lim";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll();
}
