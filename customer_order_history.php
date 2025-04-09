<?php
session_start();
require_once __DIR__. '/nav.php';
require_once __DIR__. '/Utilities/Connection.php';
require_once __DIR__ . '/service/Customer_Order_Operations.php';
$orders = getAllOrderHistory($_SESSION['customer_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <style>
        /* styles.css */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

    </style>
</head>
<body>
<div class="container">
    <h1>Order History</h1>

    <table border="1">
        <thead>
        <tr>
            <th>Order ID</th>
            <th>Order Date</th>
            <th>Order Time</th>
            <th>Amount</th>
            <th>Delivery Date</th>
            <th>Delivery %</th>
            <th>Delivery Status</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $orders->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><a href="customer_order_details.php?order_id=<?php echo htmlspecialchars($row['order_id']); ?>"> <?php echo htmlspecialchars($row['order_id']); ?> </a></td>
                <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                <td><?php echo htmlspecialchars($row['order_time']); ?></td>
                <td><?php echo '$' . number_format($row['amount'], 2); ?></td>
                <td><?php echo htmlspecialchars($row['deliver_date']); ?></td>
                <td><?php echo htmlspecialchars($row['deliver_percent']) . '%'; ?></td>
                <td><?php echo htmlspecialchars($row['deliver_status']); ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>