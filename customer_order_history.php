<?php
session_start();
require_once __DIR__. '/nav.php';
require_once __DIR__. '/Utilities/Connection.php';
require_once __DIR__ . '/service/Customer_Order_Operations.php';

// Get the orders
$customer_id = $_SESSION['customer_id'];
$orders = getAllOrderHistory($customer_id);

// Calculate statistics first before using the result set
$totalOrders = 0;
$totalSpent = 0;
$pendingOrders = 0;
$completedOrders = 0;

// We'll fetch all orders into an array to use for statistics and display
$ordersArray = [];
while ($row = $orders->fetch(PDO::FETCH_ASSOC)) {
    $ordersArray[] = $row;
    
    $totalOrders++;
    $totalSpent += $row['amount'];
    
    if (strtolower($row['deliver_status']) == 'pending' || strtolower($row['deliver_status']) == 'processing') {
        $pendingOrders++;
    }
    
    if (strtolower($row['deliver_status']) == 'completed' || strtolower($row['deliver_status']) == 'delivered') {
        $completedOrders++;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History | FarmFresh Market</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        ::root {
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
            position: relative;
        }
    
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: var(--white);
            box-shadow: var(--shadow);
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
        
        .order-summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .summary-card {
            background-color: var(--light-gray);
            padding: 15px;
            border-radius: 8px;
            min-width: 200px;
            flex: 1;
            text-align: center;
            transition: var(--transition);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .summary-title {
            color: var(--dark-gray);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .summary-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .summary-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
        
        tbody tr {
            transition: var(--transition);
        }
        
        tbody tr:nth-child(even) {
            background-color: rgba(76, 175, 80, 0.05);
        }
        
        tbody tr:hover {
            background-color: rgba(76, 175, 80, 0.1);
        }
        
        .order-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }
        
        .order-link:hover {
            color: var(--secondary-color);
        }
        
        .order-link i {
            margin-right: 5px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-completed {
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
        
        .status-processing {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .progress-bar-container {
            width: 100%;
            background-color: var(--medium-gray);
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
            background-color: var(--primary-color);
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 0;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            color: var(--medium-gray);
            margin-bottom: 20px;
        }
        
        .empty-state-message {
            font-size: 1.2rem;
            color: var(--dark-gray);
            margin-bottom: 20px;
        }
        
        .shop-now-btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--white);
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .shop-now-btn:hover {
            background-color: var(--secondary-color);
        }
        
        @media (max-width: 992px) {
            .container {
                width: 90%;
            }
            
            .summary-card {
                min-width: 170px;
            }
        }
        
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }
            
            .order-summary {
                flex-direction: column;
            }
            
            .summary-card {
                width: 100%;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            th, td {
                padding: 12px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container" style="box-shadow: none; margin-bottom: 0;">
            <h1>Order History</h1>
            <p class="subtitle">Track and manage your previous orders</p>
        </div>
    </div>

    <div class="container">
        <?php
        // Check if there are any orders
        if (!empty($ordersArray)):
        ?>
        
        <div class="order-summary">
            <div class="summary-card">
                <div class="summary-icon"><i class="fas fa-shopping-bag"></i></div>
                <div class="summary-title">Total Orders</div>
                <div class="summary-value"><?= $totalOrders ?></div>
            </div>
            
            <div class="summary-card">
                <div class="summary-icon"><i class="fas fa-coins"></i></div>
                <div class="summary-title">Total Spent</div>
                <div class="summary-value">RM <?= number_format($totalSpent, 2) ?></div>
            </div>
            
            <div class="summary-card">
                <div class="summary-icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="summary-title">Pending Orders</div>
                <div class="summary-value"><?= $pendingOrders ?></div>
            </div>
            
            <div class="summary-card">
                <div class="summary-icon"><i class="fas fa-check-circle"></i></div>
                <div class="summary-title">Completed Orders</div>
                <div class="summary-value"><?= $completedOrders ?></div>
            </div>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Order Time</th>
                    <th>Amount</th>
                    <th>Delivery Date</th>
                    <th>Progress</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($ordersArray as $row): 
                // Determine status class
                $statusClass = 'status-pending';
                
                if (strtolower($row['deliver_status']) == 'completed' || strtolower($row['deliver_status']) == 'delivered') {
                    $statusClass = 'status-completed';
                } elseif (strtolower($row['deliver_status']) == 'cancelled') {
                    $statusClass = 'status-cancelled';
                } elseif (strtolower($row['deliver_status']) == 'processing') {
                    $statusClass = 'status-processing';
                }
            ?>
                <tr>
                    <td>
                        <a href="customer_order_details.php?order_id=<?= htmlspecialchars($row['order_id']); ?>" class="order-link">
                            <i class="fas fa-file-invoice"></i> <?= htmlspecialchars($row['order_id']); ?>
                        </a>
                    </td>
                    <td><?= date('F j, Y', strtotime($row['order_date'])); ?></td>
                    <td><?= date('h:i A', strtotime($row['order_time'])); ?></td>
                    <td>RM <?= number_format($row['amount'], 2); ?></td>
                    <td>
                        <?= $row['deliver_date'] ? date('F j, Y', strtotime($row['deliver_date'])) : '-'; ?>
                    </td>
                                        <td>
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: <?= htmlspecialchars($row['deliver_percent']); ?>%"></div>
                        </div>
                        <div style="text-align: center; font-size: 0.8rem; margin-top: 5px;">
                            <?= htmlspecialchars($row['deliver_percent']); ?>%
                        </div>
                    </td>
                    <td>
                        <span class="status-badge <?= $statusClass; ?>">
                            <?= htmlspecialchars($row['deliver_status']); ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="empty-state-message">
                    You haven't placed any orders yet.
                </div>
                <a href="products.php" class="shop-now-btn">
                    <i class="fas fa-store"></i> Start Shopping
                </a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>