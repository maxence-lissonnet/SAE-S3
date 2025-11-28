<?php
// Model/modcom.php

/**
 * Connexion PDO à la base EcoGestUM
 * (si getPDO existe déjà dans un autre modèle, on ne le redéfinit pas)
 */
if (!function_exists('getPDO')) {

    function getPDO(): PDO
    {
        $host    = 'localhost';
        $db      = 'EcoGestUM';   // adapte si besoin
        $user    = 'root';        // adapte si besoin
        $pass    = '';            // adapte si besoin
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        return new PDO($dsn, $user, $pass, $options);
    }
}

/* ============================================================
   LISTES / LECTURE
   ============================================================ */

/**
 * Tous les types de communication.
 * (nom historique utilisé dans certains contrôleurs)
 */
function getAllComTypes(): array
{
    $pdo = getPDO();
    $sql = "SELECT idTypeCom, nomTypeCom
            FROM TYPE_COMMUNICATION
            ORDER BY nomTypeCom";
    return $pdo->query($sql)->fetchAll();
}

/**
 * Alias pour compatibilité avec l’ancien nom getAllTypeCom()
 */
function getAllTypeCom(): array
{
    return getAllComTypes();
}

/**
 * Tous les rôles (si utilisé dans les écrans associés).
 */
function getAllRoles(): array
{
    $pdo = getPDO();
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
    $pdo = getPDO();

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

    // Filtre type
    if (!empty($idTypeCom)) {
        $sql .= " AND c.idTypeCom = :idTypeCom";
        $params[':idTypeCom'] = $idTypeCom;
    }

    // Filtre date
    if (!empty($dateFilter)) {
        $dateFilter = trim($dateFilter);

        if (preg_match('#^\d{4}$#', $dateFilter)) {
            // année
            $sql .= " AND YEAR(c.datePubCom) = :year";
            $params[':year'] = $dateFilter;

        } elseif (preg_match('#^\d{4}-\d{2}$#', $dateFilter)) {
            // année-mois
            $sql .= " AND c.datePubCom BETWEEN :d1 AND :d2";
            $params[':d1'] = $dateFilter . '-01';
            $params[':d2'] = $dateFilter . '-31';

        } elseif (preg_match('#^\d{4}-\d{2}-\d{2}$#', $dateFilter)) {
            // date complète
            $sql .= " AND c.datePubCom = :dExact";
            $params[':dExact'] = $dateFilter;

        } else {
            // fallback sur LIKE
            $sql .= " AND c.datePubCom LIKE :dLike";
            $params[':dLike'] = $dateFilter . '%';
        }
    }

    $sql .= " ORDER BY c.datePubCom DESC, c.heurePubCom DESC, c.idCom DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Une communication par son id (pour la page com.php, etc.).
 */
function getCommunicationById(int $idCom): ?array
{
    $pdo = getPDO();

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

/**
 * Dernières communications pour la page d’accueil.
 * $limit = nombre maximum d’actus à afficher.
 */
function getLastCommunications(int $limit = 3): array
{
    $pdo = getPDO();

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

/* ============================================================
   ÉCRITURE / CRUD
   ============================================================ */

/**
 * Insertion d’une communication.
 */
function insertCommunication(array $data): int
{
    $pdo = getPDO();

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

/**
 * Mise à jour d’une communication existante.
 */
function updateCommunication(int $idCom, array $data): void
{
    $pdo = getPDO();

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

/**
 * Suppression d’une communication.
 */
function deleteCommunication(int $idCom): void
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("DELETE FROM COMMUNICATION WHERE idCom = :id");
    $stmt->execute([':id' => $idCom]);
}
