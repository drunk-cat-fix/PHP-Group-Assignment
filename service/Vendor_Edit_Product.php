<?php
use entities\Vendor;
require_once __DIR__ . '\..\entities\Vendor.php';
require_once __DIR__ . '\..\dao\VendorDao.php';
require_once __DIR__ . '\..\Utilities\Connection.php';

// Ensure user is logged in
if (!isset($_SESSION['vendor_id'])) {
    die("Unauthorized access! Please log in.");
}

// Check if product ID exists in URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$product_id = $_GET['id'];
$vendor_id = $_SESSION['vendor_id'];

// Fetch product data
$conn = getConnection();
$sql = "SELECT product_id, product_name, product_desc, product_category, product_qty, 
               product_packaging, product_price, product_profile 
        FROM product 
        WHERE product_id = :product_id AND product_vendor = :vendor_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$stmt->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found or you do not have permission to edit it.");
}

if ($_POST) {
    $vendor = new Vendor();
    $vendor->setId($_SESSION['vendor_id']);
    $vendor->setProductID($product_id);
    $vendor->setProductName($_POST['product_name']);
    $vendor->setProductDesc($_POST['product_desc']);
    $vendor->setProductCategory($_POST['product_category']);
    $vendor->setQuantity($_POST['product_qty']);
    $vendor->setProductPackaging($_POST['product_packaging']);
    $vendor->setPrice($_POST['product_price']);

    // Handle product profile image upload
    if (!empty($_FILES['profile']['tmp_name'])) {
        $target = $_FILES['profile']['tmp_name'];
        $file = fopen($target, "rb");
        $size = filesize($target);
        $content = fread($file, $size);
        fclose($file);
        $vendor->setProductProfile($content);
    }

    $vendorDao = new VendorDao();
    $action = $vendorDao->editProduct($vendor);

    if ($action) {
        header("location: vendor_product.php");
    } else {
        header("location: vendor_product.php?errMsg=Failed to add product!");
    }
    exit();
}

?>