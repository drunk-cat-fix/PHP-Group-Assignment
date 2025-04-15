<?php
session_start();

// Check if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

// Process payment and create order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Calculate total
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Create order
    $trackingNumber = 'ORD-' . uniqid();
    $order = [
        'tracking_number' => $trackingNumber,
        'items' => $_SESSION['cart'],
        'total' => $total,
        'start_time' => time(),
        'status' => 'Order Received'
    ];

    // Save to current order and history
    $_SESSION['order'] = $order;
    
    // Initialize order history if not exists
    if (!isset($_SESSION['order_history'])) {
        $_SESSION['order_history'] = [];
    }
    $_SESSION['order_history'][] = $order;

    // Clear cart
    $_SESSION['cart'] = [];

    // Redirect to order tracking
    header("Location: order_tracking.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #2e7d32; }
        .order-summary { margin: 20px 0; }
        .order-item { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .total { font-weight: bold; font-size: 1.2em; margin-top: 20px; padding-top: 10px; border-top: 1px solid #ccc; }
        .payment-form { margin-top: 30px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .pay-btn { background-color: #4caf50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
        .pay-btn:hover { background-color: #388e3c; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment</h1>
        
        <div class="order-summary">
            <h3>Order Summary</h3>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <div class="order-item">
                    <span><?= htmlspecialchars($item['product']) ?> (<?= $item['quantity'] ?> <?= htmlspecialchars($item['unit']) ?>)</span>
                    <span>RM <?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                </div>
            <?php endforeach; ?>
            <div class="total">Total: RM <?= number_format(array_reduce($_SESSION['cart'], function($carry, $item) { 
                return $carry + ($item['price'] * $item['quantity']); 
            }, 0), 2) ?></div>
        </div>

        <form class="payment-form" method="POST">
            <div class="form-group">
                <label for="name">Cardholder Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="card">Card Number</label>
                <input type="text" id="card" name="card" required>
            </div>
            <div class="form-group">
                <label for="expiry">Expiry Date</label>
                <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" required>
            </div>
            <button type="submit" class="pay-btn">Complete Payment</button>
        </form>
    </div>
</body>
</html>