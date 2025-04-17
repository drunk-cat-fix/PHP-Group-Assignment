<?php
require_once __DIR__ . '/../Utilities/Connection.php';

$conn = getConnection();
$query = "
    SELECT co.order_id, co.customer_id, c.customer_name, co.order_date, co.order_time, co.amount, co.deliver_status
    FROM customer_order co
    JOIN customer c ON co.customer_id = c.customer_id
    ORDER BY co.order_date DESC, co.order_time DESC
";
$stmt = $conn->prepare($query);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>