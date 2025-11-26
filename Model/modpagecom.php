<?php
// Model/modpagecom.php

/**
 * Connexion PDO à la base EcoGestUM
 * On la définit uniquement si elle n’existe pas déjà
 * (par exemple parce que modEven.php a déjà été inclus).
 */
if (!function_exists('getPDO')) {

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
}

/**
 * Tous les types de communication (pour la liste déroulante).
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
 * Liste des communications avec filtres type + date partielle.
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

    // Filtre date (année, année-mois, date complète)
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

/**
 * Une communication par son id (pour la page com.php).
 */
function getCommunicationById(int $idCom): ?array
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
 * Dernières communications pour la page d'accueil.
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
