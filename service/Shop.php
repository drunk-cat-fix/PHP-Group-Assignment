<?php
require_once __DIR__ . '\..\Utilities\Connection.php';
$conn = getConnection();

$vendor_id = $_GET['id'] ?? null;
if (!$vendor_id) {
    die("No vendor ID provided.");
}

// Increment vendor_visit_count
$visit_sql = "UPDATE vendor SET vendor_visit_count = vendor_visit_count + 1 WHERE vendor_id = :vendor_id";
$visit_stmt = $conn->prepare($visit_sql);
$visit_stmt->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
$visit_stmt->execute();

// Increment shop_search_count if shop was accessed from search
if (isset($_GET['id'], $_GET['from_search']) && $_GET['from_search'] == '1') {
    $vendorId = $_GET['id'];
    if (isset($_SESSION['searched_vendor_ids']) && in_array($vendorId, $_SESSION['searched_vendor_ids'])) {
        $stmt = $conn->prepare("UPDATE vendor SET shop_search_count = shop_search_count + 1 WHERE vendor_id = :id");
        $stmt->execute([':id' => $vendorId]);
    }
}

// Fetch vendor details
$vendor_sql = "SELECT shop_name, shop_address, shop_city, shop_state, vendor_desc, vendor_tier, vendor_profile, vendor_email 
               FROM vendor 
               WHERE vendor_id = :vendor_id";
$vendor_stmt = $conn->prepare($vendor_sql);
$vendor_stmt->execute([':vendor_id' => $vendor_id]);
$vendor = $vendor_stmt->fetch(PDO::FETCH_ASSOC);

if (!$vendor) {
    die("Vendor not found.");
}

// Handle search
$query = $_GET['query'] ?? '';

// Product SQL
$product_sql = "SELECT 
                    p.product_id,
                    p.product_name,
                    p.product_desc,
                    p.product_category,
                    p.product_qty,
                    p.product_price,
                    p.product_profile,
                    p.product_promotion,
                    p.product_visit_count,
                    v.vendor_tier
                FROM product p
                JOIN vendor v ON v.vendor_id = p.product_vendor
                WHERE p.product_vendor = :vendor_id";

$params = [':vendor_id' => $vendor_id];

if (!empty($query)) {
    $product_sql .= " AND p.product_name LIKE :query";
    $params[':query'] = '%' . $query . '%';
}

// Remove ORDER BY for debugging
$product_sql .= " ORDER BY p.product_id ASC"; // Simplified for testing

$product_stmt = $conn->prepare($product_sql);
$product_stmt->execute($params);
$products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch average ratings
$rating_stmt = $conn->prepare("SELECT product_id, AVG(product_rating) as avg_rating FROM product_review GROUP BY product_id");
$rating_stmt->execute();
$ratings = $rating_stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Process products
$processedProducts = [];
foreach ($products as $product) {
    $product_id = $product['product_id'];
    $product['avg_rating'] = isset($ratings[$product_id]) ? number_format($ratings[$product_id], 2) : 'No ratings yet';
    $product['promo_price'] = (!empty($product['product_promotion']) && $product['product_promotion'] < 1) 
                                ? $product['product_price'] * $product['product_promotion'] 
                                : null;
    $processedProducts[] = $product;
}
$products = $processedProducts;
unset($_SESSION['searched_ids']);

?>