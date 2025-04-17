<?php
require_once __DIR__ . '/../Utilities/Connection.php';
$customerId = $_SESSION['customer_id'];
$notifications = [];
$conn = getConnection();

// Denied Orders Check - Get orders with denial reasons
$deniedOrdersQuery = "
    SELECT op.order_id, op.reason, 
           GROUP_CONCAT(p.product_name SEPARATOR ', ') AS products
    FROM order_product op
    JOIN product p ON op.product_id = p.product_id
    JOIN customer_order co ON op.order_id = co.order_id
    WHERE co.customer_id = ? AND op.status = 'Denied' AND op.reason IS NOT NULL
    GROUP BY op.order_id, op.reason
    ORDER BY co.order_date DESC
";

$stmt = $conn->prepare($deniedOrdersQuery);
$stmt->execute([$customerId]);
$deniedResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($deniedResult as $row) {
    $notifications[] = [
        'type' => 'Order Denied',
        'message' => "Your order #{$row['order_id']} containing {$row['products']} was denied. Reason: {$row['reason']}"
    ];
}

// Delivery Status Notifications
$deliveryStatusQuery = "
    SELECT 
        co.order_id, 
        co.order_date,
        co.deliver_date,
        co.isPending,
        co.isInProgress,
        co.isDelivered,
        GROUP_CONCAT(p.product_name SEPARATOR ', ') AS products
    FROM customer_order co
    JOIN order_product op ON co.order_id = op.order_id
    JOIN product p ON op.product_id = p.product_id
    WHERE co.customer_id = ? 
    AND (
        co.isPending = true OR 
        co.isInProgress = true OR 
        (co.isDelivered = true AND co.deliver_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY))
    )
    GROUP BY co.order_id
    ORDER BY 
        CASE 
            WHEN co.isDelivered = true THEN 3
            WHEN co.isInProgress = true THEN 2
            WHEN co.isPending = true THEN 1
        END,
        co.order_date DESC
";

$stmt = $conn->prepare($deliveryStatusQuery);
$stmt->execute([$customerId]);
$deliveryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($deliveryResult as $row) {
    if ($row['isDelivered']) {
        $deliveryDate = date('F j, Y', strtotime($row['deliver_date']));
        $notifications[] = [
            'type' => 'Order Delivered',
            'message' => "Your order #{$row['order_id']} containing {$row['products']} was delivered on {$deliveryDate}."
        ];
    } elseif ($row['isInProgress']) {
        $notifications[] = [
            'type' => 'Order In Progress',
            'message' => "Your order #{$row['order_id']} containing {$row['products']} is currently being processed and will be shipped soon."
        ];
    } elseif ($row['isPending']) {
        $orderDate = date('F j, Y', strtotime($row['order_date']));
        $notifications[] = [
            'type' => 'Order Pending',
            'message' => "Your order #{$row['order_id']} placed on {$orderDate} containing {$row['products']} is pending confirmation."
        ];
    }
}

// Sort notifications with newest first
// You could add a timestamp field to each notification for more precise sorting
usort($notifications, function($a, $b) {
    // Priority order: Delivered < In Progress < Pending < Order Denied
    $typeOrder = [
        'Order Delivered' => 4,
        'Order In Progress' => 3,
        'Order Pending' => 2,
        'Order Denied' => 1
    ];
    
    $orderA = $typeOrder[$a['type']] ?? 5; // Default to lowest priority if type not found
    $orderB = $typeOrder[$b['type']] ?? 5;
    
    return $orderA - $orderB;
});
?>