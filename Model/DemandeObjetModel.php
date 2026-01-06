<?php
require_once __DIR__ . '/BDDModel.php';

function getCategoriesDemande()
{
    $pdo = get_dtb();
    $sql = "SELECT idCategorie, nomCategorie FROM CATEGORIE ORDER BY nomCategorie ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getLieuxRetrait()
{
    $pdo = get_dtb();
    $sql = "SELECT idLieuRetrait, nomLieuRetrait FROM LIEU_RETRAIT ORDER BY nomLieuRetrait ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createDemande($nomObjet, $quantite, $idLieuRetrait, $mesures, $idCategorie, $idUser)
{
    $pdo = get_dtb();

    $dim = floatval(str_replace(',', '.', $mesures));
    if ($dim == 0 && empty($mesures)) {
        $dim = null;
    }

    $sql = "INSERT INTO DEMANDE_OBJET (libelleDemandeObjet, quantiteDemandeObjet, idLieuRetrait, dimensionDemandeObjet, idCategorie, IdUser) 
            VALUES (:nom, :qte, :lieu, :dim, :cat, :user)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom', $nomObjet);
    $stmt->bindParam(':qte', $quantite);
    $stmt->bindParam(':lieu', $idLieuRetrait);
    $stmt->bindParam(':dim', $dim);
    $stmt->bindParam(':cat', $idCategorie);
    $stmt->bindParam(':user', $idUser);

    return $stmt->execute();
}

// Ajoutez cette fonction dans DemandeObjetModel.php

function notification_demande($nomObjet, $quantite, $idUserAuteur)
{
    $pdo = get_dtb();

    $titre = "Nouvelle recherche d'objet";
    $message = "Un utilisateur recherche : " . $quantite . " x " . $nomObjet . ". Aidez-le si vous possédez cet objet !";

    $pdo->beginTransaction();
    $sqlNotif = "INSERT INTO NOTIFICATION (titreNotif, descriptionNotif, dateNotification, idTypeNotification) 
                     VALUES (:titre, :msg, NOW(), (SELECT idTypeNotification FROM TYPE_NOTIFICATION LIMIT 1))";

    $stmt = $pdo->prepare($sqlNotif);
    $stmt->execute([
        'titre' => $titre,
        'msg'   => $message
    ]);

    $idNotif = $pdo->lastInsertId();
    $sqlReception = "INSERT INTO RECEPTION (IdUser, idNotif) 
                         SELECT IdUser, :idNotif FROM UTILISATEUR";

    $stmtRec = $pdo->prepare($sqlReception);
    $stmtRec->execute([
        'idNotif' => $idNotif
    ]);

    $pdo->commit();
    return true;
}
