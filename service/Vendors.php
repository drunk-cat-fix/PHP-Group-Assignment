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

// Fetch all vendor ratings
$rating_sql = "SELECT vendor_id, AVG(vendor_rating) as avg_rating 
              FROM vendor_review 
              GROUP BY vendor_id";
$rating_stmt = $conn->prepare($rating_sql);
$rating_stmt->execute();
$ratings = $rating_stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Add ratings to vendors array without using references
$processedVendors = [];
foreach ($vendors as $vendor) {
    $vendor_id = $vendor['vendor_id'];
    $vendor['avg_rating'] = isset($ratings[$vendor_id]) ? $ratings[$vendor_id] : null;
    $processedVendors[] = $vendor;
}
$vendors = $processedVendors;

$_SESSION['searched_vendor_ids'] = array_column($vendors, 'vendor_id');
?>