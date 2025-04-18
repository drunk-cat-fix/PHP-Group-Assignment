<?php
session_start();
require_once 'service/Customer_Notification.php';
require_once 'nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Notifications</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .notification {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 6px;
            background-color: #f9f9f9;
        }
        .notification h4 {
            margin: 0 0 5px 0;
            display: flex;
            align-items: center;
        }
        .notification h4::before {
            margin-right: 8px;
            font-size: 20px;
        }
        .notification.order-denied {
            border-left: 4px solid #dc3545;
        }
        .notification.order-denied h4::before {
            content: "❌";
        }
        .notification.order-delivered {
            border-left: 4px solid #28a745;
        }
        .notification.order-delivered h4::before {
            content: "✅";
        }
        .notification.order-in-progress {
            border-left: 4px solid #ffc107;
        }
        .notification.order-in-progress h4::before {
            content: "🚚";
        }
        .notification.order-pending {
            border-left: 4px solid #17a2b8;
        }
        .notification.order-pending h4::before {
            content: "⏳";
        }
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 8px 16px;
            background-color: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
        }
        .back-button:hover {
            background-color: #e0e0e0;
        }
        .no-notifications {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 6px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <a href="products.php" class="back-button">← Back to Dashboard</a>
    <h2>My Notifications</h2>
        <?php if (empty($notifications)): ?>
        <div class="no-notifications">No new notifications 🎉</div>
    <?php endif; ?>
    <?php foreach ($notifications as $note): ?>
        <div class="notification <?= strtolower(str_replace(' ', '-', $note['type'])) ?>">
            <h4><?= htmlspecialchars($note['type']) ?></h4>
            <p><?= htmlspecialchars($note['message']) ?></p>
            <form method="post" action="customer_notifications_page.php">
                <input type="hidden" name="order_id" value="<?= htmlspecialchars($note['order_id']) ?>">
                <input type="hidden" name="type" value="<?= htmlspecialchars($note['type']) ?>">
                <button type="submit">Mark as Read</button>
            </form>
        </div>
    <?php endforeach; ?>

</body>
</html>