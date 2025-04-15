<?php
require_once __DIR__ . '\..\Utilities\Connection.php';
require_once __DIR__ . '\..\service\Customer_Order_Operations.php';
$_SESSION['customer_id'] = 1;
$conn = getConnection();
$customer_id = $_SESSION['customer_id'] ?? null;
$order_id = $_POST['reorder_order_id'] ?? $_GET['order_id'] ?? null;

$reorderItems = [];
$subtotal = 0;
$grand_total = 0;

if ($customer_id && $order_id) {
    $stmt = getOrderDetailsByCustomerIdAndOrderId($customer_id, $order_id);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row['item_total_price'] = $row['ordered_quantity'] * $row['product_price'];
        $subtotal += $row['item_total_price'];
        $reorderItems[] = $row;
    }
    $grand_total = $subtotal;
}
?>