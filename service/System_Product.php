<?php
require_once __DIR__ . '/../Utilities/Connection.php';

$conn = getConnection();
$sql = "SELECT 
            p.product_id, 
            v.vendor_name, 
            p.product_name, 
            p.product_desc, 
            p.product_category, 
            p.product_qty, 
            p.product_packaging, 
            p.product_price, 
            p.product_profile, 
            p.product_visit_count,
            ROUND(AVG(r.product_rating), 2) AS avg_rating
        FROM product p 
        JOIN vendor v ON p.product_vendor = v.vendor_id
        LEFT JOIN product_review r ON r.product_id = p.product_id
        GROUP BY p.product_id, v.vendor_name, p.product_name, p.product_desc, p.product_category, 
                 p.product_qty, p.product_packaging, p.product_price, p.product_profile, p.product_visit_count";

$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>