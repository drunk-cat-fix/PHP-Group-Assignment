<?php
require_once __DIR__ . '\..\entities\Admin.php';
require_once __DIR__ . '\..\dao\AdminDao.php';
require_once __DIR__ . '\..\Utilities\Connection.php';

$conn = getConnection();

// Query for pending orders: Orders where all order_product statuses are 'Complete'
$pendingOrdersQuery = "
    SELECT co.order_id, co.customer_id, co.order_date, co.order_time, co.amount
    FROM customer_order co
    WHERE co.deliver_status = 'Pending'
      AND NOT EXISTS (
        SELECT 1 FROM order_product op
        WHERE op.order_id = co.order_id
        AND op.status <> 'Complete'
    )
";
$pendingOrdersStmt = $conn->prepare($pendingOrdersQuery);
$pendingOrdersStmt->execute();
$pendingOrders = $pendingOrdersStmt->fetchAll(PDO::FETCH_ASSOC);

// Query for ongoing orders: deliver_status is 'In Progress' OR 'Complete' but deliver_date <= 30 days ago
$ongoingOrdersQuery = "
    SELECT order_id, customer_id, order_date, order_time, amount, deliver_date, deliver_percent, deliver_status
    FROM customer_order
    WHERE deliver_status = 'In Progress'
    OR (deliver_status = 'Complete' AND deliver_date >= CURDATE() - INTERVAL 30 DAY) ORDER BY order_id DESC
";
$ongoingOrdersStmt = $conn->prepare($ongoingOrdersQuery);
$ongoingOrdersStmt->execute();
$ongoingOrders = $ongoingOrdersStmt->fetchAll(PDO::FETCH_ASSOC);
?>