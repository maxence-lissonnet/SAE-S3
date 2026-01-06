<?php
require_once __DIR__ . '/BDDModel.php';


function getAllEventTypes(): array
{
    $pdo = get_dtb();
    $sql = "SELECT idTypeEvent, nomTypeEvent
            FROM TYPE_EVENEMENT
            ORDER BY nomTypeEvent";
    return $pdo->query($sql)->fetchAll();
}


function getEventsFiltered(?int $idTypeEvent, ?string $dateFilter, ?string $lieuSearch): array
{
    $pdo = get_dtb();

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
            $sql .= " AND evenement.dateEvent BETWEEN :d1 AND :d2";
            $params[':d1'] = $dateFilter . '-01';
            $params[':d2'] = $dateFilter . '-31';

        } elseif (preg_match('#^\d{4}-\d{2}-\d{2}$#', $dateFilter)) {
            // date complète
            $sql .= " AND evenement.dateEvent = :dExact";
            $params[':dExact'] = $dateFilter;

        } else {
            // fallback : LIKE sur le début de la date
            $sql .= " AND evenement.dateEvent LIKE :dLike";
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


function getEventsForMonth(string $yearMonth, ?int $idTypeEvent, ?string $lieuSearch): array
{
    $pdo = get_dtb();

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


function getEventById(int $idEvent): ?array
{
    $pdo = get_dtb();
    $sql = "SELECT evenement.idEvent, evenement.nomEvent, evenement.descEvent, evenement.dateEvent,
            evenement.lieuEvent, evenement.heureDebEvent, evenement.heureFinEvent, evenement.idTypeEvent
            FROM EVENEMENT 
            WHERE evenement.idEvent = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $idEvent]);
    $row = $stmt->fetch();
    return $row ?: null;
}


function insertEvent(array $data): int
{
    $pdo = get_dtb();
    $sql = "INSERT INTO EVENEMENT
              (nomEvent, descEvent, dateEvent, lieuEvent,
               heureDebEvent, heureFinEvent, idTypeEvent)
            VALUES
              (:nom, :descr, :date, :lieu, :hDeb, :hFin, :type)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $data['nomEvent'],
        ':descr' => $data['descEvent'] ?? 'Pas de contenu',
        ':date' => $data['dateEvent'],
        ':lieu' => $data['lieuEvent'] ?? null,
        ':hDeb' => $data['heureDebEvent'],
        ':hFin' => $data['heureFinEvent'] ?: null,
        ':type' => $data['idTypeEvent'],
    ]);
    return (int) $pdo->lastInsertId();
}


function updateEvent(int $idEvent, array $data): void
{
    $pdo = get_dtb();
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
        ':nom' => $data['nomEvent'],
        ':descr' => $data['descEvent'] ?? 'Pas de contenu',
        ':date' => $data['dateEvent'],
        ':lieu' => $data['lieuEvent'] ?? null,
        ':hDeb' => $data['heureDebEvent'],
        ':hFin' => $data['heureFinEvent'] ?: null,
        ':type' => $data['idTypeEvent'],
        ':id' => $idEvent,
    ]);
}


function deleteEvent(int $idEvent): void
{
    $pdo = get_dtb();
    $stmt = $pdo->prepare("DELETE FROM EVENEMENT WHERE idEvent = :id");
    $stmt->execute([':id' => $idEvent]);
}

function getNextEvents(int $limit = 2): array
{
    $pdo = get_dtb();

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
