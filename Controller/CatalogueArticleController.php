<?php
require_once __DIR__ . '/../Model/CatalogueArticleModel.php';

$articles = get_obj();

require __DIR__ . '/../Vue/CatalogueArticleVue.php';
?>