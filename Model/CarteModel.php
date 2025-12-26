<?php
function get_bdd()
{
    static $pdo = null;
    if ($pdo === null) {
        $hostname = $_ENV['DB_HOST_NAME'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];
        $db_name = $_ENV['DB_NAME'];

        $dsn = "mysql:host=$hostname;dbname=$db_name;charset=utf8mb4";
        $pdo =  new PDO($dsn, $user, $password);
    }

    return $pdo;
}

function get_items(string $table)
{
    $dtb = get_bdd();
    $query = $dtb->query('SELECT * FROM ' . $table);
    $items = $query->fetchAll(PDO::FETCH_ASSOC);
    return $items;
}
