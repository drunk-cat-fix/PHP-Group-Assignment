<?php
use entities\Vendor;
session_start();
require_once __DIR__ . '\..\entities\Vendor.php';
require_once __DIR__ . '\..\dao\VendorDao.php';
require_once __DIR__ . '\..\Utilities\Connection.php';

$conn = getConnection();

if ($_POST) {
    $vendor = new Vendor();
    $vendor->setId($_SESSION['vendor_id']);
    $vendor->setProductName($_POST['product_name']);
    $vendor->setProductDesc($_POST['product_desc']);
    $vendor->setProductCategory($_POST['product_category']);
    $vendor->setQuantity($_POST['quantity']);
    $vendor->setProductPackaging($_POST['product_packaging']);
    $vendor->setPrice($_POST['price']);
    $target = $_FILES['profile']['tmp_name'];
    $file = fopen($target, "rb");
    $size = filesize($target);
    $content = fread($file, $size);
    $vendor->setProductProfile($content);
    $vendorDao = new VendorDao();
    $action = $vendorDao->addProduct($vendor);
    if ($action) {
        header("location: ../vendor_product.php");
    } else {
        header("location: ../vendor_product.php?errMsg=Failed to add product!");
    }
}

?>