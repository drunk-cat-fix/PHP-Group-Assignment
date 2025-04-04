<?php
$_SESSION['vendor_id'] = 3;
use entities\Vendor;
require_once __DIR__ . '\..\entities\Vendor.php';
require_once __DIR__ . '\..\dao\VendorDao.php';
require_once __DIR__ . '\..\Utilities\Connection.php';

// Ensure user is logged in
if (!isset($_SESSION['vendor_id'])) {
    die("Unauthorized access! Please log in.");
}

// Check if service ID exists in URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid service ID.");
}

$service_id = $_GET['id'];
$vendor_id = $_SESSION['vendor_id'];

// Fetch service data
$conn = getConnection();
$sql = "SELECT service_id, service_name, service_desc, service_category, service_price, service_profile 
        FROM service 
        WHERE service_id = :service_id AND service_vendor = :vendor_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
$stmt->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
$stmt->execute();
$service = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$service) {
    die("Service not found or you do not have permission to edit it.");
}

if ($_POST) {
    $vendor = new Vendor();
    $vendor->setId($_SESSION['vendor_id']);
    $vendor->setServiceID($service_id);
    $vendor->setServiceName($_POST['service_name']);
    $vendor->setServiceDesc($_POST['service_desc']);
    $vendor->setServiceCategory($_POST['service_category']);
    $vendor->setPrice($_POST['service_price']);

    // Handle service profile image upload
    if (!empty($_FILES['profile']['tmp_name'])) {
        $target = $_FILES['profile']['tmp_name'];
        $file = fopen($target, "rb");
        $size = filesize($target);
        $content = fread($file, $size);
        fclose($file);
        $vendor->setServiceProfile($content);
    }

    $vendorDao = new VendorDao();
    $action = $vendorDao->editService($vendor);

    if ($action) {
        header("location: vendor_service.php");
    } else {
        header("location: vendor_service.php?errMsg=Failed to add service!");
    }
    exit();
}

?>