<?php

function get_bdd(){
    $hostname = 'localhost';
    $user = 'root';
    $password = '';
    $db_name = 'ecogestum';

    $dsn = "mysql:host=$hostname;dbname=$db_name;charset=utf8mb4";
    $pdo =  new PDO($dsn, $user, $password);

    return $pdo;
}

function get_obj(){
    $bdd = get_bdd();
    $query = $bdd->query('SELECT objet.idObjet, objet.nomObjet, objet.imageObjet, lieu_retrait.adresseLieuRetrait, 
                        etat_objet.nomEtatObjet, utilisateur.nomUser, utilisateur.prenomUser FROM objet 
                        INNER JOIN utilisateur ON utilisateur.IdUser = objet.idUser 
                        INNER JOIN lieu_retrait ON lieu_retrait.idLieuRetrait = objet.idLieuRetrait 
                        INNER JOIN etat_objet ON etat_objet.idEtatObjet = objet.idEtatObjet');
    $articles = $query->fetchAll(PDO::FETCH_ASSOC);
    return $articles;
}

function get_categories(){
    $bdd = get_bdd();
    $query = $bdd->query('SELECT DISTINCT * FROM categorie');
    $categories = $query->fetchAll(PDO::FETCH_ASSOC);
    return $categories;
}

function get_locations(){
    $bdd = get_bdd();
    $query = $bdd->query('SELECT DISTINCT adresseLieuRetrait FROM lieu_retrait');
    $locations = $query->fetchAll(PDO::FETCH_ASSOC);
    return $locations;
}

function get_etat(){
    $bdd = get_bdd();
    $query = $bdd->query('SELECT DISTINCT nomEtatObjet FROM etat_objet');
    $states = $query->fetchAll(PDO::FETCH_ASSOC);
    return $states;
}

function filter_articles_categorie($categorie){
    $bdd = get_bdd();
    $query = $bdd->prepare('SELECT  objet.idObjet, objet.nomObjet, objet.imageObjet, lieu_retrait.adresseLieuRetrait, 
                        etat_objet.nomEtatObjet, utilisateur.nomUser, utilisateur.prenomUser FROM objet 
                        INNER JOIN utilisateur ON utilisateur.IdUser = objet.idUser 
                        INNER JOIN lieu_retrait ON lieu_retrait.idLieuRetrait = objet.idLieuRetrait 
                        INNER JOIN etat_objet ON etat_objet.idEtatObjet = objet.idEtatObjet
                        WHERE objet.idCategorie = :categorie');
    $query->execute([
        'categorie' => $categorie
    ]);
    $filtered_articles = $query->fetchAll(PDO::FETCH_ASSOC);
    return $filtered_articles;
}

function filter_articles_localisation($localisation){
    $bdd = get_bdd();
    $query = $bdd->prepare('SELECT objet.idObjet, objet.nomObjet, objet.imageObjet, lieu_retrait.adresseLieuRetrait, 
                        etat_objet.nomEtatObjet, utilisateur.nomUser, utilisateur.prenomUser FROM objet 
                        INNER JOIN utilisateur ON utilisateur.IdUser = objet.idUser 
                        INNER JOIN lieu_retrait ON lieu_retrait.idLieuRetrait = objet.idLieuRetrait 
                        INNER JOIN etat_objet ON etat_objet.idEtatObjet = objet.idEtatObjet
                        WHERE lieu_retrait.adresseLieuRetrait = :localisation');
    $query->execute([
        'localisation' => $localisation
    ]);
    $filtered_articles = $query->fetchAll(PDO::FETCH_ASSOC);
    return $filtered_articles;
}

function filter_articles_etat($etat){
    $bdd = get_bdd();
    $query = $bdd->prepare('SELECT objet.idObjet, objet.nomObjet, objet.imageObjet, lieu_retrait.adresseLieuRetrait, 
                        etat_objet.nomEtatObjet, utilisateur.nomUser, utilisateur.prenomUser FROM objet 
                        INNER JOIN utilisateur ON utilisateur.IdUser = objet.idUser 
                        INNER JOIN lieu_retrait ON lieu_retrait.idLieuRetrait = objet.idLieuRetrait 
                        INNER JOIN etat_objet ON etat_objet.idEtatObjet = objet.idEtatObjet
                        WHERE etat_objet.nomEtatObjet = :etat');
    $query->execute([
        'etat' => $etat
    ]);
    $filtered_articles = $query->fetchAll(PDO::FETCH_ASSOC);
    return $filtered_articles;
}

function filter_articles_categorie_localisation($categorie, $localisation){
    $bdd = get_bdd();
    $query = $bdd->prepare('SELECT objet.idObjet, objet.nomObjet, objet.imageObjet, lieu_retrait.adresseLieuRetrait, 
                        etat_objet.nomEtatObjet, utilisateur.nomUser, utilisateur.prenomUser FROM objet 
                        INNER JOIN utilisateur ON utilisateur.IdUser = objet.idUser 
                        INNER JOIN lieu_retrait ON lieu_retrait.idLieuRetrait = objet.idLieuRetrait 
                        INNER JOIN etat_objet ON etat_objet.idEtatObjet = objet.idEtatObjet
                        WHERE objet.idCategorie = :categorie AND lieu_retrait.adresseLieuRetrait = :localisation');
    $query->execute([
        'categorie' => $categorie,
        'localisation' => $localisation
    ]);
    $filtered_articles = $query->fetchAll(PDO::FETCH_ASSOC);
    return $filtered_articles;
}

function filter_articles_categorie_etat($categorie, $etat){
    $bdd = get_bdd();
    $query = $bdd->prepare('SELECT objet.idObjet, objet.nomObjet, objet.imageObjet, lieu_retrait.adresseLieuRetrait, 
                        etat_objet.nomEtatObjet, utilisateur.nomUser, utilisateur.prenomUser FROM objet 
                        INNER JOIN utilisateur ON utilisateur.IdUser = objet.idUser 
                        INNER JOIN lieu_retrait ON lieu_retrait.idLieuRetrait = objet.idLieuRetrait 
                        INNER JOIN etat_objet ON etat_objet.idEtatObjet = objet.idEtatObjet
                        WHERE objet.idCategorie = :categorie AND etat_objet.nomEtatObjet = :etat');
    $query->execute([
        'categorie' => $categorie,
        'etat' => $etat
    ]);
    $filtered_articles = $query->fetchAll(PDO::FETCH_ASSOC);
    return $filtered_articles;
}

function filter_articles_localisation_etat($localisation, $etat){
    $bdd = get_bdd();
    $query = $bdd->prepare('SELECT objet.idObjet, objet.nomObjet, objet.imageObjet, lieu_retrait.adresseLieuRetrait, 
                        etat_objet.nomEtatObjet, utilisateur.nomUser, utilisateur.prenomUser FROM objet 
                        INNER JOIN utilisateur ON utilisateur.IdUser = objet.idUser 
                        INNER JOIN lieu_retrait ON lieu_retrait.idLieuRetrait = objet.idLieuRetrait 
                        INNER JOIN etat_objet ON etat_objet.idEtatObjet = objet.idEtatObjet
                        WHERE lieu_retrait.adresseLieuRetrait = :localisation AND etat_objet.nomEtatObjet = :etat');
    $query->execute([
        'localisation' => $localisation,
        'etat' => $etat
    ]);
    $filtered_articles = $query->fetchAll(PDO::FETCH_ASSOC);
    return $filtered_articles;
}

function filter_articles_all($categorie, $localisation, $etat){
    $bdd = get_bdd();
    $query = $bdd->prepare('SELECT objet.idObjet, objet.nomObjet, objet.imageObjet, lieu_retrait.adresseLieuRetrait, 
                        etat_objet.nomEtatObjet, utilisateur.nomUser, utilisateur.prenomUser FROM objet 
                        INNER JOIN utilisateur ON utilisateur.IdUser = objet.idUser 
                        INNER JOIN lieu_retrait ON lieu_retrait.idLieuRetrait = objet.idLieuRetrait 
                        INNER JOIN etat_objet ON etat_objet.idEtatObjet = objet.idEtatObjet
                        WHERE objet.idCategorie = :categorie AND lieu_retrait.adresseLieuRetrait = :localisation 
                        AND etat_objet.nomEtatObjet = :etat');
    $query->execute([
        'categorie' => $categorie,
        'localisation' => $localisation,
        'etat' => $etat
    ]);
    $filtered_articles = $query->fetchAll(PDO::FETCH_ASSOC);
    return $filtered_articles;
}
?>