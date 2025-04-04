<?php
require_once __DIR__ . '/../Utilities/Connection.php';

$conn = getConnection();
$sql = "SELECT p.product_id, v.vendor_name, p.product_name, p.product_desc, p.product_category, p.product_qty, 
               p.product_packaging, p.product_price, p.product_rating, p.product_profile, p.product_visit_count 
        FROM product p JOIN vendor v on p.product_vendor = v.vendor_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>