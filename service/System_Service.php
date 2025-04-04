<?php
require_once __DIR__ . '/../Utilities/Connection.php';

$conn = getConnection();
$sql = "SELECT s.service_id, v.vendor_name, s.service_name, s.service_desc, s.service_category, 
               s.service_price, s.service_profile 
        FROM service s JOIN vendor v on s.service_vendor = v.vendor_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>