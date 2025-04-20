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
        // For reordering, we need to get current product price and promotion
        $productStmt = $conn->prepare("SELECT product_price, product_promotion FROM product WHERE product_id = ?");
        $productStmt->execute([$row['product_id']]);
        $productData = $productStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($productData) {
            $currentPrice = $productData['product_price'];
            $finalPrice = $currentPrice;
            
            // Apply promotion if exists
            if ($productData['product_promotion'] && $productData['product_promotion'] < 1) {
                $finalPrice = $currentPrice * $productData['product_promotion'];
            }
            
            $row['product_price'] = $finalPrice;
            $row['original_price'] = $currentPrice;
            $row['has_promotion'] = ($productData['product_promotion'] && $productData['product_promotion'] < 1);
            $row['promotion_factor'] = $productData['product_promotion'];
            $row['item_total_price'] = $row['ordered_quantity'] * $finalPrice;
            $subtotal += $row['item_total_price'];
            $reorderItems[] = $row;
        }
    }
    $grand_total = $subtotal;
} 
// If not reordering, check if there are items in the cart
elseif (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Get items from cart
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        // Fetch product details with promotion
        $sql = "SELECT p.product_id, p.product_name, p.product_price, p.product_promotion, v.vendor_name
                FROM product p
                JOIN vendor v ON p.product_vendor = v.vendor_id
                WHERE p.product_id = :product_id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($product) {
            // Calculate price with promotion
            $originalPrice = $product['product_price'];
            $finalPrice = $originalPrice;
            
            if ($product['product_promotion'] && $product['product_promotion'] < 1) {
                $finalPrice = $originalPrice * $product['product_promotion'];
            }
            
            $item_total = $finalPrice * $quantity;
            $reorderItems[] = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'vendor_name' => $product['vendor_name'],
                'product_price' => $finalPrice,
                'original_price' => $originalPrice,
                'has_promotion' => ($product['product_promotion'] && $product['product_promotion'] < 1),
                'promotion_factor' => $product['product_promotion'], 
                'ordered_quantity' => $quantity,
                'item_total_price' => $item_total
            ];
            $subtotal += $item_total;
        }
    }
    $grand_total = $subtotal;
}

// Store the items for payment processing
$_SESSION['reorder_items'] = $reorderItems;
$_SESSION['grand_total'] = $grand_total;
?>