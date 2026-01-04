<?php
require_once __DIR__ . '/BDDModel.php';

function get_reservations($idUser){
    $bdd = get_dtb();
    $query = $bdd->query('SELECT reservation.idreservation, reservation.dateDebReservation, reservation.dateExpreservation,
                        statut_reservation.nomStatutreservation, utilisateur.nomUser, utilisateur.prenomUser, utilisateur.emailUser,
                        objet.idObjet, objet.nomObjet, categorie.nomCategorie, LIEU_RETRAIT.nomLieuRetrait
                        FROM reservation
                        INNER JOIN statut_reservation ON reservation.idStatutreservation = statut_reservation.idStatutreservation
                        INNER JOIN RESERVER ON reservation.idreservation = RESERVER.idreservation
                        INNER JOIN utilisateur ON RESERVER.IdUser = utilisateur.IdUser
                        INNER JOIN objet ON RESERVER.idObjet = objet.idObjet
                        INNER JOIN categorie ON objet.idCategorie = categorie.idCategorie
                        INNER JOIN LIEU_RETRAIT ON objet.idLieuRetrait = LIEU_RETRAIT.idLieuRetrait;
                        WHERE utilisateur.idUser = " . $idUser . ";"');
    $reservations = $query->fetchAll(PDO::FETCH_ASSOC);
    return $reservations;
}