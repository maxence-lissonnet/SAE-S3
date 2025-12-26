<?php
// Model/modNotification.php

require_once __DIR__ . '/BDDModel.php';


/**
 * Toutes les notifications d’un utilisateur.
 */
function notif_getAllForUser(int $idUser): array
{
    $pdo = get_dtb();

    $sql = "
        SELECT
            n.idNotif,
            n.titreNotif,
            n.descriptionNotif,
            n.dateNotification,
            t.nomTypeNotification
        FROM NOTIFICATION n
        JOIN TYPE_NOTIFICATION t
          ON n.idTypeNotification = t.idTypeNotification
        JOIN RECEPTION r
          ON r.idNotif = n.idNotif
        WHERE r.idUser = :idUser
        ORDER BY n.dateNotification DESC, n.idNotif DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':idUser' => $idUser]);
    $rows = $stmt->fetchAll();

    $notifications = [];

    foreach ($rows as $row) {
        $date = new DateTime($row['dateNotification']);
        $dateTxt  = $date->format('d/m/Y H:i');
        $typeNom  = $row['nomTypeNotification'];

        // 👉 on considère "objet" comme type réservable
        $labelLower = strtolower($typeNom);
        $canReserve = (strpos($labelLower, 'objet') !== false);

        $notifications[] = [
            'id'          => (int) $row['idNotif'],
            'titre'       => $row['titreNotif'],
            'source'      => $typeNom,
            'dateTxt'     => $dateTxt,
            'type'        => $typeNom,

            'resume'      => $row['descriptionNotif'],
            'detailTitre' => $row['titreNotif'],
            'detailTexte' => $row['descriptionNotif'],

            // flag utilisé par la vue pour afficher / cacher le bouton
            'canReserve'  => $canReserve,
        ];
    }

    return $notifications;
}
