<?php
session_start();

if (!isset($_GET['tracking_number'])) {
    header("Location: order_history.php");
    exit;
}

$trackingNumber = $_GET['tracking_number'];

if (!isset($_SESSION['order_history'])) {
    header("Location: order_history.php");
    exit;
}

// Find the order in history
$foundOrder = null;
foreach ($_SESSION['order_history'] as $order) {
    if ($order['tracking_number'] === $trackingNumber) {
        $foundOrder = $order;
        break;
    }
}

if (!$foundOrder) {
    header("Location: order_history.php");
    exit;
}

// Add items to cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

foreach ($foundOrder['items'] as $item) {
    $found = false;
    foreach ($_SESSION['cart'] as &$cartItem) {
        if ($cartItem['product'] === $item['product']) {
            $cartItem['quantity'] += $item['quantity'];
            $found = true;
            break;
        }
    }
    if (!$found) {
        $_SESSION['cart'][] = $item;
    }
}

header("Location: cart.php");
exit;
?>