<?php
session_start();
require_once 'service/Admin_Order_History.php';
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
    <title>Order History</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            background-color: #f4f7fc;
            color: #333;
        }

        h2 {
            font-size: 28px;
            color: #28a745;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #28a745;
            color: white;
            font-size: 16px;
        }

        td {
            font-size: 14px;
            color: #555;
        }

        tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .status {
            padding: 5px 10px;
            border-radius: 5px;
            text-transform: capitalize;
        }

        .status.pending {
            background-color: #ffc107;
            color: white;
        }

        .status.completed {
            background-color: #28a745;
            color: white;
        }

        .status.cancelled {
            background-color: #dc3545;
            color: white;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            color: #28a745;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #28a745;
            margin: 0 5px;
            border-radius: 5px;
        }

        .pagination a:hover {
            background-color: #28a745;
            color: white;
        }

        /* Styling for mobile devices */
        @media (max-width: 768px) {
            th, td {
                padding: 8px;
            }

            h2 {
                font-size: 24px;
            }

            .pagination a {
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>
    <h2>Order History</h2>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Name</th>
                <th>Order Date</th>
                <th>Order Time</th>
                <th>Amount ($)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['order_id']) ?></td>
                    <td><?= htmlspecialchars($order['customer_id']) ?></td>
                    <td><?= htmlspecialchars($order['customer_name']) ?></td>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                    <td><?= htmlspecialchars($order['order_time']) ?></td>
                    <td><?= htmlspecialchars($order['amount']) ?></td>
                    <td>
                        <span class="status <?= strtolower($order['deliver_status']) ?>">
                            <?= htmlspecialchars($order['deliver_status']) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
