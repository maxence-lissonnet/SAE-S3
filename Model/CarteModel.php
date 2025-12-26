<?php
require_once __DIR__ . '/BDDModel.php';

function get_items(string $table)
{
    $dtb = get_dtb();
    $query = $dtb->query('SELECT * FROM ' . $table);
    $items = $query->fetchAll(PDO::FETCH_ASSOC);
    return $items;
}

?>