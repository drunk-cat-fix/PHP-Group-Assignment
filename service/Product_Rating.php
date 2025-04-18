<?php
require_once __DIR__ . '/../Utilities/Connection.php';

// Check if product ID is provided
if (!isset($_GET['id'])) {
    die("Product ID not specified.");
}

$product_id = intval($_GET['id']);
$customer_id = $_SESSION['customer_id'] ?? null;

// Check if customer is logged in
if (!$customer_id) {
    die("Customer not logged in.");
}

$conn = getConnection();

// Fetch product details
$stmt = $conn->prepare("SELECT product_name, product_category, product_profile FROM product WHERE product_id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}

// Handle form submission
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'] ?? null;
    $review = trim($_POST['review'] ?? '');

    if (!$rating || $review === '') {
        $error = "Please provide both a rating and a review.";
    } else {
        $stmt = $conn->prepare("INSERT INTO product_review (product_id, customer_id, product_review, product_rating) VALUES (?, ?, ?, ?)");
        $stmt->execute([$product_id, $customer_id, $review, $rating]);
        header("Location: product_details.php?product_id=" . $product_id); // or wherever you want to redirect
        exit();
    }
}
?>
