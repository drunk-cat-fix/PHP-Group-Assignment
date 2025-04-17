<?php
session_start();
require_once 'service/Admin_Notification.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Notifications</title>
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
        }
    </style>
</head>
<body>
    <h2>Vendor Notifications</h2>

    <?php if (!empty($notifications)): ?>
        <?php foreach ($notifications as $note): ?>
            <div class="notification">
                <h4><?= htmlspecialchars($note['type']) ?></h4>
                <p><?= htmlspecialchars($note['message']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No new notifications.</p>
    <?php endif; ?>
</body>
</html>
