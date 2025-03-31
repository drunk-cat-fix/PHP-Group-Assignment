<?php

    function getConnection(): PDO
    {
        $connection = null;
        try {
            $source = 'mysql:host=localhost:3306;dbname=GA;charset=utf8mb4;Timezone=Asia/Shanghai;';
            global $pdo;
            $pdo = new PDO($source, 'root', 'xiangyu183');
            $pdo->exec('SET NAMES utf8mb4');
            global $connection;
            $connection = $pdo;

        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $connection;
}