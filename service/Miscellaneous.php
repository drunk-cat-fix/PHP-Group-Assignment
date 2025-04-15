<?php
require_once __DIR__ . '\..\Utilities\Connection.php';

// Initialize the connection
$conn = getConnection();

// Define the SQL query to fetch product details from the 'product' table
$sql = "SELECT product_id, product_name, product_desc, product_category, product_qty, product_price, product_rating, product_profile FROM product where product_category = 'miscellaneous'";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->execute();

// Fetch all the products from the result set
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Now, you can use $products to display the product details.
?>
