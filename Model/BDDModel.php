<?php
// Model/BDDModel.php

if (!function_exists('get_bdd')) {
    function get_dtb() {
        // 1. On cherche d'abord dans $_ENV, sinon dans $_SERVER (solution pour XAMPP)
        $host = $_ENV['DB_HOST_NAME'] ?? $_SERVER['DB_HOST_NAME'] ?? null;
        $user = $_ENV['DB_USER'] ?? $_SERVER['DB_USER'] ?? null;
        $pass = $_ENV['DB_PASS'] ?? $_SERVER['DB_PASS'] ?? null;
        $name = $_ENV['DB_NAME'] ?? $_SERVER['DB_NAME'] ?? null;

        // 2. Si c'est toujours vide, alors là il y a un vrai problème
        if (!$host) {
             // Astuce de débogage : affiche le contenu de $_SERVER pour comprendre
             echo "<pre>"; print_r($_SERVER); echo "</pre>";
             die("Erreur : Impossible de lire les variables d'environnement (ni dans ENV ni dans SERVER).");
        }

        $dsn = "mysql:host={$host};dbname={$name};charset=utf8mb4";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        return new PDO($dsn, $user, $pass, $options);
    }
}
?>