<?php
require_once __DIR__ . '/../Utilities/Connection.php';

$vendorId = $_SESSION['vendor_id'];
$notifications = [];

$conn = getConnection();

// 🔸 1. Low Stock Check
$lowStockQuery = "
    SELECT product_name, product_qty 
    FROM product 
    WHERE product_qty < 20 AND product_vendor = ?
";
$stmt = $conn->prepare($lowStockQuery);
$stmt->execute([$vendorId]);
$lowStockResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($lowStockResult as $row) {
    $notifications[] = [
        'type' => 'Low Stock',
        'message' => "Product '{$row['product_name']}' is low on stock (Qty: {$row['product_qty']})."
    ];
}

// 🔸 2. Incoming Orders Check
$incomingOrdersQuery = "
    SELECT op.order_id, p.product_name, op.qty 
    FROM order_product op
    JOIN product p ON op.product_id = p.product_id
    WHERE p.product_vendor = ? AND op.status = 'Pending'
";
$stmt = $conn->prepare($incomingOrdersQuery);
$stmt->execute([$vendorId]);
$incomingResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($incomingResult as $row) {
    $notifications[] = [
        'type' => 'Incoming Order',
        'message' => "Order #{$row['order_id']} includes '{$row['product_name']}' (Qty: {$row['qty']})."
    ];
}
$notificationCount = count($notifications);
?>
