<?php
session_start();
require_once 'service/Admin_Manage_Order.php';
require_once 'service/Admin_Notification.php';
require_once 'admin_nav.php';
$notificationCount = count($notifications);
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Orders</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #f4f6f8;
        }
        h2, h3 {
            color: #333;
        }
        .card {
            background-color: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #e0e0e0;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f0f2f5;
            color: #444;
        }
        button {
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .notification {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 26px;
            text-decoration: none;
            color: #333;
        }
        .notification .badge {
            position: absolute;
            top: -10px;
            right: -12px;
            padding: 4px 7px;
            border-radius: 50%;
            background: red;
            color: white;
            font-size: 12px;
        }
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead tr {
                display: none;
            }
            td {
                padding: 10px;
                position: relative;
                padding-left: 50%;
            }
            td::before {
                position: absolute;
                top: 10px;
                left: 10px;
                width: 45%;
                white-space: nowrap;
                font-weight: bold;
                color: #666;
            }
            td:nth-of-type(1)::before { content: "Order ID"; }
            td:nth-of-type(2)::before { content: "Customer ID"; }
            td:nth-of-type(3)::before { content: "Order Date"; }
            td:nth-of-type(4)::before { content: "Order Time"; }
            td:nth-of-type(5)::before { content: "Amount"; }
            td:nth-of-type(6)::before { content: "Action/Deliver Date"; }
            td:nth-of-type(7)::before { content: "Deliver Percent"; }
            td:nth-of-type(8)::before { content: "Deliver Status"; }
        }
    </style>
</head>
<body>

<h2>Admin - Manage Orders</h2>

<div class="card">
    <h3>Pending Orders</h3>
    <?php if (count($pendingOrders) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Order Date</th>
                <th>Order Time</th>
                <th>Amount</th>
                <th>Assign Task</th>
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
                    <td>
                        <button onclick="location.href='admin_add_task.php?order_id=<?= $order['order_id'] ?>'">Create Task</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No pending orders at the moment.</p>
    <?php endif; ?>
</div>

<div class="card">
    <h3>Ongoing Orders</h3>
    <?php if (count($ongoingOrders) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Order Date</th>
                <th>Order Time</th>
                <th>Amount</th>
                <th>Deliver Date</th>
                <th>Deliver %</th>
                <th>Status</th>
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
    <?php else: ?>
        <p>No ongoing orders at the moment.</p>
    <?php endif; ?>
</div>

</body>
</html>
