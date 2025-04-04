<?php
use entities\Vendor;
require_once __DIR__ . '\..\entities\Vendor.php';
require_once __DIR__ . '\..\dao\VendorDao.php';
require_once __DIR__ . '\..\Utilities\Connection.php';

$conn = getConnection();
$vendor_id = $_SESSION['vendor_id'];

// Get orders with product information grouped by order_id
$sql = "SELECT op.order_id, GROUP_CONCAT(CONCAT(p.product_name, ' x ', op.qty) SEPARATOR ', ') AS products_info, op.status
        FROM order_product op
        JOIN product p ON op.product_id = p.product_id
        JOIN customer_order co ON op.order_id = co.order_id
        WHERE p.product_vendor = :vendor_id AND co.order_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY op.order_id, op.status";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':vendor_id', $vendor_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission for updating order status
if(isset($_POST['action']) && $_POST['action'] == 'update_status') {
    $vendor = new Vendor();
    $vendorDao = new VendorDao();
    $vendor->setOrderID($_POST['order_id']);
    $vendor->setId($_SESSION['vendor_id']);
    $vendorDao->updateOrderStatus($vendor);
    $vendorDao->selectProductsInOrder($vendor);    
    $vendorDao->calculateQuantity($vendor);           
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if(isset($_POST['action']) && $_POST['action'] == 'deny_order') {
    $vendor = new Vendor();
    $vendorDao = new VendorDao();
    $vendor->setOrderID($_POST['order_id']);
    $vendorDao->denyOrder($vendor, $_POST['reason']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}



?>