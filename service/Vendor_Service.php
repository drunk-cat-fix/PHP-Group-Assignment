<?php
require_once __DIR__ . '/../entities/Vendor.php';
require_once __DIR__ . '/../dao/VendorDao.php';
require_once __DIR__ . '/../Utilities/Connection.php';

$conn = getConnection();
$sql = "SELECT service_id, service_name, service_desc, service_category, service_price, service_profile 
        FROM service 
        WHERE service_vendor = :vendor_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>