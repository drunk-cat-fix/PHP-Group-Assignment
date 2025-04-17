<?php
require_once __DIR__ . '\..\Utilities\Connection.php';

// Initialize the connection
$conn = getConnection();

// Get search inputs
$query = $_GET['query'] ?? '';
$filter = $_GET['filter'] ?? 'shop';

// Base SQL
$sql = "SELECT 
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
        JOIN vendor v ON v.vendor_id = p.product_vendor";

// Add WHERE clause for search
$params = [];
if (!empty($query)) {
    $sql .= " WHERE p.product_name LIKE :query";
    $params[':query'] = '%' . $query . '%';
    $_SESSION['searched_ids'] = [];
}

$sql .= " ORDER BY 
            CASE v.vendor_tier
                WHEN 'Gold' THEN 1
                WHEN 'Silver' THEN 2
                WHEN 'Bronze' THEN 3
                ELSE 4
            END,
            CASE WHEN p.product_promotion IS NOT NULL THEN 0 ELSE 1 END,
            p.product_visit_count DESC,
            p.product_name ASC";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Store matched product IDs in session if searched
if (!empty($query)) {
    $_SESSION['searched_ids'] = array_column($products, 'product_id');
}

// Fetch average ratings for all products at once
$rating_stmt = $conn->prepare("SELECT product_id, AVG(product_rating) as avg_rating FROM product_review GROUP BY product_id");
$rating_stmt->execute();
$ratings = $rating_stmt->fetchAll(PDO::FETCH_KEY_PAIR); // product_id => avg_rating

// Inject rating and promotion price into each product
$processedProducts = [];
foreach ($products as $product) {
    $product_id = $product['product_id'];

    // Add rating
    $product['avg_rating'] = isset($ratings[$product_id]) ? number_format($ratings[$product_id], 2) : 'No ratings yet';

    // Add promo price if applicable
    if (!empty($product['product_promotion']) && $product['product_promotion'] < 1) {
        $product['promo_price'] = $product['product_price'] * $product['product_promotion'];
    } else {
        $product['promo_price'] = null;
    }

    $processedProducts[] = $product;
}

// Replace the original products array with the processed one
$products = $processedProducts;
unset($product);
unset($processedProducts);
?>
