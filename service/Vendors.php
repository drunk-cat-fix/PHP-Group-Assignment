<?php
require_once __DIR__ . '/../Utilities/Connection.php';

$conn = getConnection();
$query = $_GET['query'] ?? '';

// Base SQL
$sql = "SELECT vendor_id, shop_name, shop_city, vendor_desc, vendor_tier, vendor_profile FROM vendor";
$params = [];

if (!empty($query)) {
    $sql .= " WHERE shop_name LIKE :query";
    $params[':query'] = '%' . $query . '%';
}

$sql .= " ORDER BY 
            CASE vendor_tier
                WHEN 'Gold' THEN 1
                WHEN 'Silver' THEN 2
                WHEN 'Bronze' THEN 3
                ELSE 4
            END, vendor_name ASC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$vendors = $stmt->fetchAll(PDO::FETCH_ASSOC);

$_SESSION['searched_vendor_ids'] = array_column($vendors, 'vendor_id');
?>
