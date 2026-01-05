<?php
require_once __DIR__ . '/../Model/categorieModel.php';

function getCategories()
{
    return db_getCategories();
}

function getCategoryById($idCategorie)
{
    return db_getCategoryById($idCategorie);
}

function getObjetsByCategorie($idCategorie)
{
    return db_getObjetsByCategorie($idCategorie);
}
?>