<?php
session_start();
header('Content-Type: application/json');

$statuses = ['Order Received', 'Processing', 'Shipped', 'Out for Delivery', 'Delivered'];
$currentStatus = $_SESSION['order']['status'] ?? 'Order Received';

// Progress status randomly for demo
if (rand(0, 3) === 1 && $currentStatus !== 'Delivered') {
    $newIndex = array_search($currentStatus, $statuses) + 1;
    $_SESSION['order']['status'] = $statuses[$newIndex] ?? $currentStatus;
}

echo json_encode(['status' => $_SESSION['order']['status'] ?? 'No order found']);