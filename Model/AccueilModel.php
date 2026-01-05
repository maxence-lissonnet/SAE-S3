<?php
require_once __DIR__ . '/BDDModel.php';

function get_latest_objects()
{
    $bdd = get_dtb();
    $query = $bdd->query('SELECT OBJET.idObjet, OBJET.nomObjet, UTILISATEUR.nomUser, UTILISATEUR.prenomUser, LIEU_RETRAIT.nomLieuRetrait, LIEU_RETRAIT.adresseLieuRetrait,
        ETAT_OBJET.nomEtatObjet,
        OBJET.dateDispoObjet, OBJET.imageObjet FROM OBJET 
        INNER JOIN UTILISATEUR ON UTILISATEUR.IdUser = OBJET.idUser 
        INNER JOIN ETAT_OBJET ON ETAT_OBJET.idEtatObjet = OBJET.idEtatObjet
        INNER JOIN LIEU_RETRAIT ON LIEU_RETRAIT.idLieuRetrait = OBJET.idLieuRetrait
        WHERE OBJET.dateDispoObjet <= DATE(NOW())
        ORDER BY dateDispoObjet DESC LIMIT 3');
    $objects = $query->fetchAll(PDO::FETCH_ASSOC);
    return $objects;
}
