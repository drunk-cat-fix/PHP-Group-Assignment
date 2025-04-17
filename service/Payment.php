<?php
require_once __DIR__ . '/../Utilities/Connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['confirm_order'])) {
    header("Location: checkout.php");
    exit;
}

$grand_total = isset($_POST['grand_total']) ? floatval($_POST['grand_total']) : 0;

function processOrder($customer_id, $grand_total, $items) {
    $conn = getConnection(); // Get the database connection
    
    try {
        $conn->beginTransaction();

        // 1. Insert into customer_order
        $stmt = $conn->prepare("INSERT INTO customer_order (customer_id, order_date, order_time, amount, isPending) VALUES (?, CURDATE(), CURTIME(), ?, TRUE)");
        $stmt->execute([$customer_id, $grand_total]);

        $order_id = $conn->lastInsertId(); // Get the order_id from the inserted record

        // 2. Insert into order_product
        $stmt = $conn->prepare("INSERT INTO order_product (order_id, product_id, qty) VALUES (?, ?, ?)");
        foreach ($items as $item) {
            $stmt->execute([$order_id, $item['product_id'], $item['ordered_quantity']]);
        }

        // 3. Update product_qty
        $stmt = $conn->prepare("UPDATE product SET product_qty = product_qty - ? WHERE product_id = ?");
        foreach ($items as $item) {
            $stmt->execute([$item['ordered_quantity'], $item['product_id']]);
        }

        $conn->commit(); // Commit the transaction

        // Clean up session data after successful transaction
        unset($_SESSION['reorder_items']);
        unset($_SESSION['cart']); // optional, if needed

        // Redirect to order history page
        header("Location: payment_success.php");
        exit;

    } catch (Exception $e) {
        $conn->rollBack(); // Rollback the transaction if there's an error
        echo "Order failed: " . htmlspecialchars($e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['card']) || isset($_POST['tng']) || isset($_POST['bank']))) {
    $customer_id = $_SESSION['customer_id'];
    $items = isset($_SESSION['reorder_items']) ? $_SESSION['reorder_items'] : [];
    $grand_total = isset($_POST['grand_total']) ? floatval($_POST['grand_total']) : 0;

    processOrder($customer_id, $grand_total, $items);
}

?>
