<?php
use entities\Vendor;
require_once __DIR__ . '\..\entities\Vendor.php';
require_once __DIR__ . '\..\dao\VendorDao.php';
require_once __DIR__ . '\..\Utilities\Connection.php';

$_SESSION['vendor_id'] = 3;

$conn = getConnection();

if ($_POST) {
    $vendor = new Vendor();
    $vendor->setId($_SESSION['vendor_id']);
    $vendor->setServiceName($_POST['service_name']);
    $vendor->setServiceDesc($_POST['service_desc']);
    $vendor->setServiceCategory($_POST['service_category']);
    $vendor->setPrice($_POST['price']);
    $target = $_FILES['profile']['tmp_name'];
    $file = fopen($target, "rb");
    $size = filesize($target);
    $content = fread($file, $size);
    $vendor->setServiceProfile($content);
    $vendorDao = new VendorDao();
    $action = $vendorDao->addService($vendor);
    if ($action) {
        header("location: ../vendor_service.php");
    } else {
        header("location: ../vendor_service.php?errMsg=Failed to add service!");
    }
}

?>