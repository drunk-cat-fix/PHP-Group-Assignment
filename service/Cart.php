<?php
require_once __DIR__ . '\..\Utilities\Connection.php';

session_start();

$conn = getConnection();

// Initialize the cart session if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$total = 0; // To calculate the total price for all products

// Fetch the product details from the database for each item in the cart
$productDetails = [];

foreach ($_SESSION['cart'] as $item) {
    // Fetch product details from DB
    $sql = "SELECT product_name, product_price FROM product WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $item['product']);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $productDetails[] = [
            'product_name' => $product['product_name'],
            'product_price' => $product['product_price'],
            'quantity' => $item['quantity'],
            'total' => $product['product_price'] * $item['quantity']
        ];

        // Accumulate the total for all products in the cart
        $total += $product['product_price'] * $item['quantity'];
    }
}