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
    <title>Order Details | FarmFresh Market</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #45a049;
            --accent-color: #ff6b6b;
            --light-gray: #f5f5f5;
            --medium-gray: #ddd;
            --dark-gray: #666;
            --text-color: #333;
            --white: #fff;
            --shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-gray);
            color: var(--text-color);
            line-height: 1.6;
        }
        
        .page-header {
            background-color: var(--white);
            padding: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
        }
        
        h1 {
            color: var(--primary-color);
            text-align: center;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: var(--dark-gray);
            margin-bottom: 20px;
            font-size: 1rem;
        }
        
        .order-info {
            background-color: var(--light-gray);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .order-info-item {
            margin-bottom: 10px;
            flex: 1;
            min-width: 200px;
        }
        
        .order-info-label {
            font-weight: bold;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }
        
        .order-info-value {
            font-size: 1.1rem;
            color: var(--text-color);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            box-shadow: var(--shadow);
            border-radius: 8px;
            overflow: hidden;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--medium-gray);
        }
        
        th {
            background-color: var(--primary-color);
            color: var(--white);
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        tbody tr:hover {
            background-color: rgba(76, 175, 80, 0.05);
        }
        
        .total-row {
            font-weight: bold;
            background-color: var(--light-gray);
        }

        .header {
            position: relative !important;
            z-index: 9999 !important;
        }

        .navbar {
            position: relative !important;
            z-index: 9999 !important;
        }

        .page-header {
            background-color: var(--white);
            padding: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
            position: relative;
            z-index: 1; /* Ensure this is below the navigation */
            margin-top: 20px; /* Add spacing below the navbar */
            z-index: 1;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
        }
        
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 0.85rem;
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
        
        .reorder-btn {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }
        
        .reorder-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .reorder-btn i {
            margin-right: 8px;
        }
        
        .actions-container {
            display: flex;
            justify-content: flex-end;
        }
        
        @media (max-width: 768px) {
            .order-info {
                flex-direction: column;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container" style="box-shadow: none; margin-bottom: 0;">
            <h1>Order Details</h1>
            <p class="subtitle">View information about your order</p>
        </div>
    </div>

    <div class="container">
        <?php
        // Fetch the first row for order details
        $firstRow = $order->fetch(PDO::FETCH_ASSOC);
        $order->execute(); // Reset the query to fetch all items again
        
        // Check if order exists
        if ($firstRow): 
        ?>
        <div class="order-info">
            <div class="order-info-item">
                <div class="order-info-label">Order ID</div>
                <div class="order-info-value">#<?= htmlspecialchars($_GET['order_id']) ?></div>
            </div>
            
            <div class="order-info-item">
                <div class="order-info-label">Order Date</div>
                <div class="order-info-value">
                    <?= isset($firstRow['order_date']) ? date('F j, Y', strtotime($firstRow['order_date'])) : 'N/A' ?>
                </div>
            </div>
            
            <div class="order-info-item">
                <div class="order-info-label">Status</div>
                <div class="order-info-value">
                    <?php
                    $status = isset($firstRow['order_status']) ? $firstRow['order_status'] : 'Pending';
                    $statusClass = 'status-pending';
                    
                    if ($status == 'Delivered') {
                        $statusClass = 'status-delivered';
                    } elseif ($status == 'Cancelled') {
                        $statusClass = 'status-cancelled';
                    }
                    ?>
                    <span class="status <?= $statusClass ?>"><?= htmlspecialchars($status) ?></span>
                </div>
            </div>
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
                    <div hidden="hidden"><?= $total_amount += $row['item_total_price'] ?></div>
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

        <div class="actions-container">
            <form action="checkout.php" method="post">
                <input type="hidden" name="reorder_order_id" value="<?= htmlspecialchars($_GET['order_id']) ?>">
                <button type="submit" class="reorder-btn">
                    <i class="fas fa-sync-alt"></i> Reorder This
                </button>
            </form>
        </div>
        
        <?php else: ?>
            <div class="no-results" style="text-align: center; padding: 40px 0;">
                <i class="fas fa-exclamation-circle" style="font-size: 3rem; color: #ccc; display: block; margin-bottom: 20px;"></i>
                <p>No order details found. Please check the order ID and try again.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>