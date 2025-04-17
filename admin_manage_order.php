<?php
session_start();
require_once 'service/Admin_Manage_Order.php';
require_once 'service/Admin_Notification.php';
$notificationCount = count($notifications);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Orders</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .notification {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
        }
        .notification .badge {
            position: absolute;
            top: -10px;
            right: -10px;
            padding: 5px 8px;
            border-radius: 50%;
            background: red;
            color: white;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <a href="admin_notifications_page.php" class="notification">
        🔔<span class="badge"><?= $notificationCount ?></span>
    </a>
    <h2>Admin - Manage Orders</h2>
    <h3>Pending Orders</h3>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Order Date</th>
                <th>Order Time</th>
                <th>Amount</th>
                <th>Assign Staff</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendingOrders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['order_id']) ?></td>
                    <td><?= htmlspecialchars($order['customer_id']) ?></td>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                    <td><?= htmlspecialchars($order['order_time']) ?></td>
                    <td>$<?= htmlspecialchars($order['amount']) ?></td>
                    <td><button onclick="location.href='admin_add_task.php?order_id=<?= $order['order_id'] ?>'">Create Task</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <h3>Ongoing Orders</h3>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Order Date</th>
                <th>Order Time</th>
                <th>Amount</th>
                <th>Deliver Date</th>
                <th>Deliver Percent</th>
                <th>Deliver Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ongoingOrders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['order_id']) ?></td>
                    <td><?= htmlspecialchars($order['customer_id']) ?></td>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                    <td><?= htmlspecialchars($order['order_time']) ?></td>
                    <td>$<?= htmlspecialchars($order['amount']) ?></td>
                    <td><?= htmlspecialchars($order['deliver_date']) ?></td>
                    <td><?= htmlspecialchars($order['deliver_percent']) ?>%</td>
                    <td><?= htmlspecialchars($order['deliver_status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>