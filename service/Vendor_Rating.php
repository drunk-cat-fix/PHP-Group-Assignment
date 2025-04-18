<?php
require_once __DIR__ . '/../Utilities/Connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vendor_id = intval($_GET['id'] ?? 0);
    $customer_id = $_SESSION['customer_id'] ?? null;
    $rating = $_POST['rating'] ?? null;
    $review = trim($_POST['review'] ?? '');

    if (!$vendor_id || !$customer_id || !$rating || $review === '') {
        $error = "Please provide both a rating and a review.";
    } else {
        $conn = getConnection();
        $stmt = $conn->prepare("INSERT INTO vendor_review (vendor_id, customer_id, vendor_review, vendor_rating) VALUES (?, ?, ?, ?)");
        $stmt->execute([$vendor_id, $customer_id, $review, $rating]);
        header("Location: vendors.php");
        exit();
    }
}

// Check if vendor ID is provided
if (!isset($_GET['id'])) {
    die("Vendor ID not specified.");
}

$vendor_id = intval($_GET['id']);
$customer_id = $_SESSION['customer_id'] ?? null;

// Check if customer is logged in
if (!$customer_id) {
    die("Customer not logged in.");
}

$conn = getConnection();

// Fetch vendor details
$stmt = $conn->prepare("SELECT vendor_name, shop_name FROM vendor WHERE vendor_id = ?");
$stmt->execute([$vendor_id]);
$vendor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$vendor) {
    die("Vendor not found.");
}
?>