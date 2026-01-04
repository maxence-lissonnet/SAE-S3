<?php
require_once __DIR__ . '/BDDModel.php';

/**
 * Récupère tous les rapports, triés par date décroissante.
 */
function getAllRapports(): array
{
    $pdo = get_dtb();
    $sql = "SELECT idRapport, periodeRapport, descRapport 
            FROM RAPPORT 
            ORDER BY periodeRapport DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère un rapport par son ID.
 */
function getRapportById(int $idRapport): ?array
{
    $pdo = get_dtb();
    $sql = "SELECT idRapport, periodeRapport, descRapport, IdUser 
            FROM RAPPORT 
            WHERE idRapport = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $idRapport]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ?: null;
}

/**
 * Sauvegarde (Crée ou Met à jour) un rapport.
 * Note: desc est maintenant une simple chaîne de caractères.
 */
function saveRapportMetrics(?int $idRapport, string $periode, string $description, int $idUser): int
{
    $pdo = get_dtb();

    // On s'assure que la description ne dépasse pas 255 chars (limite BDD)
    $description = substr($description, 0, 255);

    if ($idRapport) {
        // Update
        $sql = "UPDATE RAPPORT 
                SET periodeRapport = :periode, descRapport = :desc, IdUser = :user
                WHERE idRapport = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':periode' => $periode,
            ':desc' => $description,
            ':user' => $idUser,
            ':id' => $idRapport
        ]);
        return $idRapport;
    } else {
        // Insert
        $sql = "INSERT INTO RAPPORT (periodeRapport, descRapport, IdUser, graphiqueRapport) 
                VALUES (:periode, :desc, :user, NULL)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':periode' => $periode,
            ':desc' => $description,
            ':user' => $idUser
        ]);
        return (int) $pdo->lastInsertId();
    }
}

/**
 * Supprime un rapport.
 */
function deleteRapport(int $idRapport): void
{
    $pdo = get_dtb();
    $stmt = $pdo->prepare("DELETE FROM RAPPORT WHERE idRapport = :id");
    $stmt->execute([':id' => $idRapport]);
}
