<?php
require_once __DIR__ . '/../Model/CatalogueArticleModel.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo 'ID invalide';
    exit;
}

$article = get_obj_by_id($id);
if (!$article) {
    http_response_code(404);
    echo 'Objet introuvable';
    exit;
}

// affiche la vue de détail
require __DIR__ . '/../Vue/DetaillObjetVue.php';
?>