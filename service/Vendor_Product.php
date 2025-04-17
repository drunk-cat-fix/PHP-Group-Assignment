<?php
require_once __DIR__ . '/../entities/Vendor.php';
require_once __DIR__ . '/../dao/VendorDao.php';
require_once __DIR__ . '/../Utilities/Connection.php';

$conn = getConnection();

// Check content type for JSON data
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if ($contentType === "application/json") {
    // Get JSON data
    $json = file_get_contents('php://input');
    error_log("Raw input: " . $json); // Log raw input
    $data = json_decode($json, true);
    
    if ($data) {
        error_log("Processing JSON data: " . print_r($data, true));
        $vendorDao = new VendorDao();
        $success = true;
        
        // Process each product update
        foreach ($data as $product) {
            // Use the full namespace
            $vendor = new \entities\Vendor();
            $vendor->setProductID($product['id']);
            $vendor->setQuantity($product['qty']);
            
            if (!$vendorDao->updateQuantity($vendor)) {
                $success = false;
                error_log("Failed to update product ID: " . $product['id']);
            }
        }
        
        if ($success) {
            echo "Success";
        } else {
            echo "Error updating one or more products";
        }
        exit;
    } else {
        error_log("Failed to parse JSON data");
        echo "Invalid JSON data";
        exit;
    }
}

// If not a JSON request, return product list
$conn = getConnection();
$sql = "SELECT product_id, product_name, product_desc, product_category, product_qty, 
               product_packaging, product_price, product_profile, product_visit_count 
        FROM product 
        WHERE product_vendor = :vendor_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$updated_products = [];

foreach ($products as $product) {
    $product_id = $product['product_id'];

    // Fetch the rating for each product
    $rating_sql = "
        SELECT AVG(pr.product_rating) AS avg_rating 
        FROM product_review pr
        JOIN product p ON pr.product_id = p.product_id
        JOIN vendor v ON v.vendor_id = p.product_vendor
        WHERE pr.product_id = :product_id
    ";
    $rating_stmt = $conn->prepare($rating_sql);
    $rating_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $rating_stmt->execute();
    $rating = $rating_stmt->fetch(PDO::FETCH_ASSOC);

    // Add the formatted rating to the product
    $product['avg_rating'] = $rating && $rating['avg_rating'] 
        ? number_format($rating['avg_rating'], 2) 
        : 'No ratings yet';

    $updated_products[] = $product;
}

// Reassign back to $products
$products = $updated_products;

?>