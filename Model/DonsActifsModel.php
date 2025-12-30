<?php

function get_bdd()
{
    static $pdo = null;
    if ($pdo === null) {
        $hostname = $_ENV['DB_HOST_NAME'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];
        $db_name = $_ENV['DB_NAME'];

        $dsn = "mysql:host=$hostname;dbname=$db_name;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $password);
    }

    return $pdo;
}

function get_objects($user)
{
    $bdd = get_bdd();
    $query = $bdd->query("SELECT * FROM OBJET 
    INNER JOIN LIEU_RETRAIT ON OBJET.idLieuRetrait = LIEU_RETRAIT.idLieuRetrait 
    WHERE idUser = " . $user . ";");
    $objects = $query->fetchAll(PDO::FETCH_ASSOC);
    return $objects;
}

function get_object_by_id($id)
{
    $bdd = get_bdd();
    $query = $bdd->query("SELECT * FROM OBJET
    INNER JOIN CATEGORIE ON CATEGORIE.idCategorie = OBJET.idCategorie
    INNER JOIN UTILISATEUR ON UTILISATEUR.IdUser = OBJET.IdUser
    INNER JOIN LIEU_RETRAIT ON LIEU_RETRAIT.idLieuRetrait = OBJET.idLieuRetrait
    INNER JOIN ETAT_OBJET ON ETAT_OBJET.idEtatObjet = OBJET.idEtatObjet WHERE idObjet = " . $id);
    $object = $query->fetch(PDO::FETCH_ASSOC);
    return $object;
}

function delete_object($id)
{
    $bdd = get_bdd();
    $query = $bdd->prepare('DELETE FROM OBJET WHERE idObjet = ?;');
    return $query->execute([$id]);
}
