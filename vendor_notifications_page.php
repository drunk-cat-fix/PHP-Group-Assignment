<?php
session_start();
require_once 'service/Vendor_Notification.php';
require_once 'vendor_nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Notifications</title>
    <style>
        /* Scoped container for this page to avoid style clashes */
        .vendor-notifications-wrapper {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f8;
            padding: 20px;
        }

        .vendor-notifications-wrapper h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .vendor-notifications-wrapper .notification {
            border-left: 6px solid #007bff;
            background: #fff;
            padding: 15px 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: relative;
            transition: all 0.3s ease-in-out;
        }

        .vendor-notifications-wrapper .notification.low-stock {
            border-left-color: #ffc107;
        }

        .vendor-notifications-wrapper .notification.order {
            border-left-color: #28a745;
        }

        .vendor-notifications-wrapper .notification h4 {
            margin: 0;
            font-size: 18px;
            color: #222;
        }

        .vendor-notifications-wrapper .notification p {
            margin: 8px 0 0;
            font-size: 15px;
            color: #555;
        }

        .vendor-notifications-wrapper .icon {
            font-size: 20px;
            margin-right: 10px;
            vertical-align: middle;
        }

        .vendor-notifications-wrapper .no-notification {
            font-size: 16px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="vendor-notifications-wrapper">
        <h2>📢 Vendor Notifications</h2>

        <?php if (!empty($notifications)): ?>
            <?php foreach ($notifications as $note): ?>
                <?php
                    $typeClass = strtolower($note['type']) === 'low stock' ? 'low-stock' : (strtolower($note['type']) === 'order' ? 'order' : '');
                    $icon = strtolower($note['type']) === 'low stock' ? '⚠️' : (strtolower($note['type']) === 'order' ? '📦' : '🔔');
                ?>
                <div class="notification <?= $typeClass ?>">
                    <h4><span class="icon"><?= $icon ?></span><?= htmlspecialchars($note['type']) ?></h4>
                    <p><?= htmlspecialchars($note['message']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-notification">You have no new notifications.</p>
        <?php endif; ?>
    </div>
</body>
</html>
