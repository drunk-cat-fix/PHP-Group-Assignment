<?php
require_once __DIR__ . '/../Utilities/Connection.php';
$conn = getConnection();

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize the cart session if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Process form actions (update and remove)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update']) && isset($_POST['product']) && isset($_POST['quantity'])) {
        $product_id = $_POST['product'];
        $quantity = (int)$_POST['quantity'];
        
        if ($quantity > 0) {
            $_SESSION['cart'][$product_id] = $quantity;
            $_SESSION['toast'] = "Cart updated successfully!";
        }
    } elseif (isset($_POST['remove']) && isset($_POST['product'])) {
        $product_id = $_POST['product'];
        
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
            $_SESSION['toast'] = "Item removed from cart!";
        }
    }
    
    // Redirect to prevent form resubmission
    header("Location: cart.php");
    exit;
}

$total = 0; // To calculate the total price for all products
// Fetch the product details from the database for each item in the cart
$productDetails = [];

foreach ($_SESSION['cart'] as $product_id => $quantity) {
    // Fetch product details from DB including promotion
    $sql = "SELECT product_id, product_name, product_price, product_promotion FROM product WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product) {
        // Calculate the actual price based on promotion
        $actualPrice = $product['product_price'];
        $finalPrice = $actualPrice;
        
        // If there's a promotion, apply it
        if ($product['product_promotion'] && $product['product_promotion'] < 1) {
            $finalPrice = $actualPrice * $product['product_promotion'];
        }
        
        $productDetails[] = [
            'product_id' => $product['product_id'],
            'product_name' => $product['product_name'],
            'product_price' => $finalPrice,
            'original_price' => $actualPrice,
            'has_promotion' => ($product['product_promotion'] && $product['product_promotion'] < 1),
            'promotion_factor' => $product['product_promotion'],
            'quantity' => $quantity,
            'total' => $finalPrice * $quantity
        ];
        
        // Accumulate the total for all products in the cart
        $total += $finalPrice * $quantity;
    }
}
?>