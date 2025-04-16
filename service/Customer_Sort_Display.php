<?php
require_once __DIR__ . "/../dao/ProductDao.php";

function getAllProducts($orderBy): array
{
    $productDao = new ProductDao();
    return $productDao->getAllProducts($orderBy);
}