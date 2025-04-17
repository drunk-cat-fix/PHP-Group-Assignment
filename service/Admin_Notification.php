<?php
require_once __DIR__ . '/../Utilities/Connection.php';

$notifications = [];

$conn = getConnection();

// 🔸 Check for pending orders that need task assignment
$query = "
    SELECT co.order_id, co.customer_id, co.order_date, co.order_time, co.amount
    FROM customer_order co
    WHERE co.deliver_status = 'Pending'
      AND NOT EXISTS (
        SELECT 1 FROM order_product op
        WHERE op.order_id = co.order_id
        AND op.status <> 'Complete'
    )
";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $row) {
    $notifications[] = [
        'type' => 'Unassigned Task',
        'message' => "Please assign task for Order #{$row['order_id']}."
    ];
}
?>
