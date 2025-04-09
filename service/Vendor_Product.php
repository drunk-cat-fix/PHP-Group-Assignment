<?php
require_once __DIR__ . '/../entities/Vendor.php';
require_once __DIR__ . '/../dao/VendorDao.php';
require_once __DIR__ . '/../Utilities/Connection.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
               product_packaging, product_price, product_rating, product_profile, product_visit_count 
        FROM product 
        WHERE product_vendor = :vendor_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>