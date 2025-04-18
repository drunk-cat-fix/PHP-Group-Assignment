<?php
require_once __DIR__ . '\..\Utilities\Connection.php';

if (!isset($_GET['product_id'])) {
    die("Product ID not specified.");
}

$product_id = $_GET['product_id'];

$conn = getConnection();

// Fetch product name and its reviews
$sql = "
    SELECT p.product_name, pr.product_review, pr.product_rating, c.customer_name
    FROM product_review pr
    JOIN customer c ON pr.customer_id = c.customer_id
    JOIN product p ON pr.product_id = p.product_id
    WHERE pr.product_id = :product_id
";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get product name from first row (if any)
$product_name = count($reviews) > 0 ? $reviews[0]['product_name'] : '';
?>