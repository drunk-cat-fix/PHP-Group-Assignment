<?php
require_once __DIR__ . '/../Utilities/Connection.php';

$conn = getConnection();
$query = "SELECT customer_id, customer_name, customer_email, customer_address, customer_city, customer_state, customer_profile FROM customer";
$stmt = $conn->prepare($query);
$stmt->execute();
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>