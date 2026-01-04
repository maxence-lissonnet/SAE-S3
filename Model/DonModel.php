<?php
require_once __DIR__ . '/BDDModel.php';

function get_categories_Don()
{
    $bdd = get_dtb();
    $query = $bdd->query('SELECT DISTINCT * FROM categorie');
    $categories = $query->fetchAll(PDO::FETCH_ASSOC);
    return $categories;
}

function get_locations_Don()
{
    $bdd = get_dtb();
    $query = $bdd->query('SELECT DISTINCT * FROM lieu_retrait');
    $locations = $query->fetchAll(PDO::FETCH_ASSOC);
    return $locations;
}

function get_etats_Don()
{
    $bdd = get_dtb();
    $query = $bdd->query('SELECT DISTINCT * FROM etat_objet');
    $states = $query->fetchAll(PDO::FETCH_ASSOC);
    return $states;
}

function add_object_Don($image)
{
    $bdd = get_dtb();
    $query = $bdd->prepare('INSERT INTO OBJET(nomObjet, descriptionObjet, imageObjet, quantiteObjet, dateDispoObjet, mesureObjet, idCategorie, idLieuRetrait, idEtatObjet, idUser)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');
    return $query->execute([$_POST['nom'], $_POST['description'], $image, $_POST['quantite'], $_POST['disponibilite'], $_POST['mesures'], $_POST['categorie'], $_POST['lieuRetrait'], $_POST['etat'], $_SESSION['idUser']]);
}
