<?php
require_once __DIR__ . '/../Utilities/Connection.php';
require_once __DIR__ . '/../service/Customer_Order_Operations.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = getConnection();
$customer_id = $_SESSION['customer_id'] ?? 1; // Default to 1 if not set
$order_id = $_POST['reorder_order_id'] ?? $_GET['order_id'] ?? null;
$reorderItems = [];
$subtotal = 0;
$grand_total = 0;

// Check if we're reordering an existing order
if ($customer_id && $order_id) {
    $stmt = getOrderDetailsByCustomerIdAndOrderId($customer_id, $order_id);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row['item_total_price'] = $row['ordered_quantity'] * $row['product_price'];
        $subtotal += $row['item_total_price'];
        $reorderItems[] = $row;
    }
    $grand_total = $subtotal;
} 
// If not reordering, check if there are items in the cart
elseif (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Get items from cart
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        // Fetch product details
        $sql = "SELECT p.product_id, p.product_name, p.product_price, v.vendor_name
                FROM product p
                JOIN vendor v ON p.product_vendor = v.vendor_id
                WHERE p.product_id = :product_id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($product) {
            $item_total = $product['product_price'] * $quantity;
            $reorderItems[] = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'vendor_name' => $product['vendor_name'],
                'product_price' => $product['product_price'],
                'ordered_quantity' => $quantity,
                'item_total_price' => $item_total
            ];
            $subtotal += $item_total;
        }
    }
    $grand_total = $subtotal;
}
?>