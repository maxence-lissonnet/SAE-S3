<?php
require_once __DIR__ . '/../../Model/statsModel.php';

function getLastThreeStats()
{
    return db_getLastThreeStats();
}

function getAllStats()
{
    return db_getAllStats();
}

function getStatById($idStat)
{
    return db_getStatById($idStat);
}

function creerStatistique($titre, $contenu, $imageData, $idTypeStatistique, $idUser)
{
    return db_creerStatistique($titre, $contenu, $imageData, $idTypeStatistique, $idUser);
}

require_once __DIR__ . '/../../Vue/Autre/stats.php';

?>