<?php
session_start();
require_once __DIR__. '/nav.php';
require_once __DIR__. '/Utilities/Connection.php';
require_once __DIR__. '/service/Customer_Order_Operations.php';
$order = getOrderDetailsByCustomerIdAndOrderId($_SESSION['customer_id'], $_GET['order_id']);
$total_amount = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }
        .order-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Order Details</h1>
    </div>

    <div class="order-info">
    </div>

    <table>
        <thead>
        <tr>
            <th>Product</th>
            <th>Vendor</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $subtotal = 0;
        while ($row = $order->fetch(PDO::FETCH_ASSOC)) :
            $subtotal += $row['item_total_price'];
            ?>
            <tr>
                <td><?= htmlspecialchars($row['product_name']) ?></td>
                <td><?= htmlspecialchars($row['vendor_name']) ?></td>
                <td>RM <?= number_format($row['product_price'], 2) ?></td>
                <td><?= htmlspecialchars($row['ordered_quantity']) ?></td>
                <td>RM <?= number_format($row['item_total_price'], 2) ?></td>
                <div hidden="hidden"><?= $total_amount+=$row['item_total_price'] ?> </div>
            </tr>
        <?php endwhile; ?>
        </tbody>
        <tfoot>
        <tr class="total-row">
            <td colspan="4" style="text-align: right;">Subtotal:</td>
            <td>RM <?= number_format($subtotal, 2) ?></td>
        </tr>
        <tr class="total-row">
            <td colspan="4" style="text-align: right;">Order Total:</td>
            <td>RM <?= number_format($total_amount, 2) ?></td>
        </tr>
        </tfoot>
    </table>
    <form action="checkout.php" method="post">
        <input type="hidden" name="reorder_order_id" value="<?= htmlspecialchars($_GET['order_id']) ?>">
        <button type="submit" style="
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        ">Reorder This</button>
    </form>
</div>
</body>
</html>