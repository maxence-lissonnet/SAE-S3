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

function get_reservation_by_id($id){
    $bdd = get_dtb();
    $query = $bdd->query('SELECT reservation.idreservation, reservation.dateDebReservation, reservation.dateExpreservation,
                        statut_reservation.nomStatutreservation, utilisateur.nomUser, utilisateur.prenomUser, utilisateur.emailUser,
                        objet.idObjet, objet.nomObjet, objet.descriptionObjet, objet.imageObjet, objet.quantiteObjet, objet.mesureObjet,
                        categorie.nomCategorie, ETAT_OBJET.nomEtatObjet,
                        LIEU_RETRAIT.nomLieuRetrait, LIEU_RETRAIT.adresseLieuRetrait
                        FROM reservation
                        INNER JOIN statut_reservation ON reservation.idStatutreservation = statut_reservation.idStatutreservation
                        INNER JOIN RESERVER ON reservation.idreservation = RESERVER.idreservation
                        INNER JOIN utilisateur ON RESERVER.IdUser = utilisateur.IdUser
                        INNER JOIN objet ON RESERVER.idObjet = objet.idObjet
                        INNER JOIN categorie ON objet.idCategorie = categorie.idCategorie
                        INNER JOIN ETAT_OBJET ON objet.idEtatObjet = ETAT_OBJET.idEtatObjet
                        INNER JOIN LIEU_RETRAIT ON objet.idLieuRetrait = LIEU_RETRAIT.idLieuRetrait
                        WHERE objet.idObjet = ' . $id . ';');
    $reservation = $query->fetch(PDO::FETCH_ASSOC);
    return $reservation;
}

function delete_reservation($id){
    $bdd = get_dtb();
    $stmt = $bdd->prepare('DELETE FROM reserver WHERE idReservation = ?');
    $stmt->execute([$id]);
    $stmt = $bdd->prepare('DELETE FROM reservation WHERE idReservation = ?');
    $stmt->execute([$id]);
}