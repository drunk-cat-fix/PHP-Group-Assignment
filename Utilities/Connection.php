<?php

function getConnection(): PDO
{
    $connection = null;
    try {
        $source = 'mysql:host=localhost:3306;dbname=GA;charset=utf8mb4;Timezone=Asia/Shanghai;';
        $pdo = new PDO($source, 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <-- Add this!
        $pdo->exec('SET NAMES utf8mb4');
        global $connection;
        $connection = $pdo;

    } catch (Exception $e) {
        echo "Database connection failed: " . $e->getMessage();
    }
    return $connection;
}
