<?php
require_once __DIR__ . '\..\Utilities\Connection.php';

$conn = getConnection();

// Check if the form has been submitted to add a product to the cart
if (isset($_POST['add_to_cart'])) {
    // Get product ID and quantity from the form
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if the cart already exists in the session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        // If product exists in cart, update the quantity
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        // If product does not exist in the cart, add it
        $_SESSION['cart'][$product_id] = $quantity;
    }

    // Optionally, set a message to confirm the product was added
    $_SESSION['message'] = "Product added to cart!";
}

// Get the product ID from the URL
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : 0;

// Fetch the product details from the database
$sql = "SELECT 
            p.product_name,
            p.product_desc,
            p.product_category,
            p.product_qty,
            p.product_packaging,
            p.product_price,
            v.vendor_name,
            p.product_profile
        FROM product p
        JOIN vendor v ON v.vendor_id = p.product_vendor
        WHERE p.product_id = :product_id";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$stmt->execute();

// Fetch the product details
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch the rating for the product
$rating_sql = "SELECT AVG(product_rating) as avg_rating FROM product_review WHERE product_id = :product_id";
$rating_stmt = $conn->prepare($rating_sql);
$rating_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$rating_stmt->execute();
$rating = $rating_stmt->fetch(PDO::FETCH_ASSOC);

// Calculate the average rating (if there are reviews)
$avg_rating = $rating['avg_rating'] ? number_format($rating['avg_rating'], 2) : 'No ratings yet';
?>