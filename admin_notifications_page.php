<?php
session_start();
require_once 'service/Admin_Notification.php';
require_once 'admin_nav.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Notifications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f9;
            color: #333;
        }
        
        h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #4CAF50;
            text-align: center;
        }
        
        .notification {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }
        
        .notification:hover {
            transform: translateY(-5px);
        }
        
        .notification h4 {
            font-size: 18px;
            color: #4CAF50;
            margin: 0 0 10px 0;
            font-weight: 600;
        }

        .notification p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }
        
        .notification .date {
            font-size: 12px;
            color: #888;
            margin-top: 10px;
        }

        .no-notifications {
            text-align: center;
            font-size: 18px;
            color: #888;
        }

        /* Styling for mobile devices */
        @media (max-width: 768px) {
            h2 {
                font-size: 24px;
            }
            
            .notification {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <h2>Admin Notifications</h2>

    <?php if (!empty($notifications)): ?>
        <?php foreach ($notifications as $note): ?>
            <div class="notification">
                <h4><?= htmlspecialchars($note['type']) ?></h4>
                <p><?= htmlspecialchars($note['message']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-notifications">No new notifications.</p>
    <?php endif; ?>

</body>
</html>
