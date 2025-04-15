<?php
session_start();
$orderHistory = isset($_SESSION['order_history']) ? $_SESSION['order_history'] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order History</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { 
            font-family: 'Segoe UI', sans-serif; 
            background: #f9f9f9; 
            padding: 20px; 
        }
        .container { 
            max-width: 800px; 
            margin: auto; 
            background: #fff; 
            padding: 20px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
            border-radius: 12px; 
        }
        h1 { 
            text-align: center; 
            color: #2e7d32; 
        }
        .order {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
        .order:last-child {
            border: none;
        }
        .order h2 {
            margin: 0;
            color: #333;
        }
        .order p {
            margin: 4px 0;
            font-size: 0.95rem;
            color: #555;
        }
        .btn {
            display: inline-block;
            padding: 8px 14px;
            background: #4caf50;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 10px;
        }
        .btn:hover {
            background: #388e3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Order History</h1>
        <?php if (!empty($orderHistory)): ?>
            <?php foreach (array_reverse($orderHistory) as $order): ?>
                <div class="order">
                    <h2>Order <?php echo htmlspecialchars($order['tracking_number']); ?></h2>
                    <p><strong>Date:</strong> <?php echo date("Y-m-d H:i:s", $order['start_time']); ?></p>
                    <p><strong>Total:</strong> RM <?php echo number_format($order['total'], 2); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
                    <a href="reorder.php?tracking_number=<?php echo urlencode($order['tracking_number']); ?>" class="btn">Reorder</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>You have no past orders.</p>
        <?php endif; ?>
        <div style="text-align:center; margin-top:20px;">
            <a href="index.php" class="btn">Return Home</a>
        </div>
    </div>
</body>
</html>
