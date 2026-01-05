<?php
require_once __DIR__ . '/BDDModel.php';

function getAllComTypes(): array {
    $pdo = get_dtb();
    $sql = "SELECT idTypeCom, nomTypeCom
            FROM TYPE_COMMUNICATION
            ORDER BY nomTypeCom";
    return $pdo->query($sql)->fetchAll();
}

/** Alias pour compatibilité */
function getAllTypeCom(): array {
    return getAllComTypes();
}

/** Tous les rôles */
function getAllRoles(): array {
    $pdo = get_dtb();
    $sql = "SELECT idRole, nomRole
            FROM ROLE
            ORDER BY nomRole";
    return $pdo->query($sql)->fetchAll();
}

/**
 * Liste des communications avec filtres type + date.
 * $dateFilter : "2025", "2025-10" ou "2025-10-02".
 */
function getCommunicationsFiltered(?int $idTypeCom, ?string $dateFilter): array
{
    $pdo = get_dtb();

    $sql = "SELECT 
                c.idCom,
                c.titreCom,
                c.contenuCom,
                c.datePubCom,
                c.heurePubCom,
                c.dateModifCom,
                c.heureModifCom,
                c.PJCom,
                tc.nomTypeCom,
                u.prenomUser,
                u.nomUser
            FROM COMMUNICATION c
            JOIN TYPE_COMMUNICATION tc ON tc.idTypeCom = c.idTypeCom
            JOIN UTILISATEUR u         ON u.IdUser     = c.IdUser
            WHERE 1";
    $params = [];

    if (!empty($idTypeCom)) {
        $sql .= " AND c.idTypeCom = :idTypeCom";
        $params[':idTypeCom'] = $idTypeCom;
    }

    if (!empty($dateFilter)) {
        $dateFilter = trim($dateFilter);

        if (preg_match('#^\d{4}$#', $dateFilter)) {
            $sql .= " AND YEAR(c.datePubCom) = :year";
            $params[':year'] = $dateFilter;

        } elseif (preg_match('#^\d{4}-\d{2}$#', $dateFilter)) {
            $sql .= " AND c.datePubCom BETWEEN :d1 AND :d2";
            $params[':d1'] = $dateFilter . '-01';
            $params[':d2'] = $dateFilter . '-31';

        } elseif (preg_match('#^\d{4}-\d{2}-\d{2}$#', $dateFilter)) {
            $sql .= " AND c.datePubCom = :dExact";
            $params[':dExact'] = $dateFilter;

        } else {
            $sql .= " AND c.datePubCom LIKE :dLike";
            $params[':dLike'] = $dateFilter . '%';
        }
    }

    $sql .= " ORDER BY c.datePubCom DESC, c.heurePubCom DESC, c.idCom DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/** Une communication par id */
function getCommunicationById(int $idCom): ?array
{
    $pdo = get_dtb();

    $sql = "SELECT 
                c.*,
                tc.nomTypeCom,
                u.prenomUser,
                u.nomUser,
                CONCAT(u.prenomUser, ' ', u.nomUser) AS auteur
            FROM COMMUNICATION c
            JOIN TYPE_COMMUNICATION tc ON tc.idTypeCom = c.idTypeCom
            JOIN UTILISATEUR u         ON u.IdUser     = c.IdUser
            WHERE c.idCom = :idCom";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':idCom' => $idCom]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ?: null;
}

/** Dernières communications */
function getLastCommunications(int $limit = 3): array
{
    $pdo = get_dtb();

    $sql = "SELECT
                c.idCom,
                c.titreCom,
                c.contenuCom,
                c.datePubCom,
                c.heurePubCom,
                tc.nomTypeCom
            FROM COMMUNICATION c
            JOIN TYPE_COMMUNICATION tc ON tc.idTypeCom = c.idTypeCom
            ORDER BY c.datePubCom DESC, c.heurePubCom DESC, c.idCom DESC
            LIMIT :lim";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll();
}

/* ===================== CRUD ===================== */

function insertCommunication(array $data): int
{
    $pdo = get_dtb();

    $sql = "INSERT INTO COMMUNICATION
              (titreCom, contenuCom,
               datePubCom, heurePubCom,
               dateModifCom, heureModifCom,
               PJCom, idTypeCom, IdUser)
            VALUES
              (:titre, :contenu,
               :dPub, :hPub,
               :dMod, :hMod,
               NULL, :idTypeCom, :idUser)";

    $nowDate = date('Y-m-d');
    $nowTime = date('H:i:s');

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titre'      => $data['titreCom'],
        ':contenu'    => $data['contenuCom'] ?? 'Pas de contenu',
        ':dPub'       => $nowDate,
        ':hPub'       => $nowTime,
        ':dMod'       => $nowDate,
        ':hMod'       => $nowTime,
        ':idTypeCom'  => $data['idTypeCom'],
        ':idUser'     => $data['IdUser'] ?? 1,
    ]);

    return (int)$pdo->lastInsertId();
}

function updateCommunication(int $idCom, array $data): void
{
    $pdo = get_dtb();

    $sql = "UPDATE COMMUNICATION
            SET titreCom      = :titre,
                contenuCom    = :contenu,
                dateModifCom  = :dMod,
                heureModifCom = :hMod,
                idTypeCom     = :idTypeCom
            WHERE idCom       = :idCom";

    $nowDate = date('Y-m-d');
    $nowTime = date('H:i:s');

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titre'      => $data['titreCom'],
        ':contenu'    => $data['contenuCom'] ?? 'Pas de contenu',
        ':dMod'       => $nowDate,
        ':hMod'       => $nowTime,
        ':idTypeCom'  => $data['idTypeCom'],
        ':idCom'      => $idCom,
    ]);
}

function deleteCommunication(int $idCom): void
{
    $pdo = get_dtb();
    $stmt = $pdo->prepare("DELETE FROM COMMUNICATION WHERE idCom = :id");
    $stmt->execute([':id' => $idCom]);
}

/* ===================== DESTINATAIRES (ROLES) ===================== */
/* Modif ajoutée : 2 fonctions utilisées par AjoutComController.php */

function getRoleIdsForCommunication(int $idCom): array
{
    $pdo = get_dtb();
    $stmt = $pdo->prepare("SELECT idRole FROM COMMUNICATION_ROLE WHERE idCom = :id");
    $stmt->execute([':id' => $idCom]);
    return array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
}

function replaceCommunicationRoles(int $idCom, array $roleIds): void
{
    $pdo = get_dtb();

    // On supprime tout puis on ré-insère
    $stmt = $pdo->prepare("DELETE FROM COMMUNICATION_ROLE WHERE idCom = :id");
    $stmt->execute([':id' => $idCom]);

    // Vide = “tous”
    if (empty($roleIds)) {
        return;
    }

    $stmt = $pdo->prepare("INSERT INTO COMMUNICATION_ROLE (idCom, idRole) VALUES (:idCom, :idRole)");
    foreach ($roleIds as $idRole) {
        $stmt->execute([
            ':idCom'  => $idCom,
            ':idRole' => (int)$idRole
        ]);
    }
}
