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
    $query = $bdd->query('SELECT objet.nomObjet, objet.imageObjet, lieu_retrait.adresseLieuRetrait, 
                        etat_objet.nomEtatObjet, utilisateur.nomUser FROM objet 
                        INNER JOIN utilisateur ON utilisateur.IdUser = objet.idUser 
                        INNER JOIN lieu_retrait ON lieu_retrait.idLieuRetrait = objet.idLieuRetrait 
                        INNER JOIN etat_objet ON etat_objet.idEtatObjet = objet.idEtatObjet');
    $articles = $query->fetchAll(PDO::FETCH_ASSOC);
    return $articles;
}
?>