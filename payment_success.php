<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful | AgriMarket Solutions</title>
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
            padding-top: 0;
            margin-top: 0;
        }
        
        /* Ensure header has proper z-index */
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
            z-index: 1;
            margin-top: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
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
        
        .success-card {
            background-color: var(--white);
            padding: 40px;
            border-radius: 8px;
            text-align: center;
            transition: var(--transition);
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }
        
        .success-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        
        .success-icon {
            font-size: 5rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            animation: pulse 1.5s infinite alternate;
        }
        
        @keyframes pulse {
            from {
                transform: scale(1);
                opacity: 1;
            }
            to {
                transform: scale(1.05);
                opacity: 0.9;
            }
        }
        
        .success-title {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .success-message {
            color: var(--dark-gray);
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        
        .return-btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--white);
            padding: 14px 28px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }
        
        .return-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .order-info {
            background-color: var(--light-gray);
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 25px;
            border-left: 4px solid var(--primary-color);
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: 600;
            color: var(--dark-gray);
        }
        
        .info-value {
            color: var(--text-color);
        }
        
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }
            
            .success-card {
                padding: 25px;
            }
            
            .success-title {
                font-size: 1.8rem;
            }
        }
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
            padding-top: 0;
            margin-top: 0;
        }
        
        /* Ensure header has proper z-index */
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

        .container:first-of-type {
            position: relative;
            z-index: 1;
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
        
        .summary-card {
            background-color: var(--light-gray);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            transition: var(--transition);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
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
        
        .product-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }
        
        .product-link:hover {
            color: var(--secondary-color);
        }
        
        .product-link i {
            margin-right: 5px;
        }
        
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid var(--medium-gray);
        }
        
        .price {
            font-weight: bold;
            color: var(--accent-color);
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
        }
        
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            th, td {
                padding: 12px 10px;
            }
            
            .product-image {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container" style="box-shadow: none; margin-bottom: 0;">
            <h1>Payment Status</h1>
            <p class="subtitle">Your order has been processed</p>
        </div>
    </div>

    <div class="container">
        <div class="success-card">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="success-title">Payment Successful!</div>
            <div class="success-message">
                Thank you for your purchase. Your payment has been received and your order is being processed.
            </div>
            
            <!-- This section could include order details if available in session -->
            <div class="order-info">
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-calendar-check"></i> Payment Date:</span>
                    <span class="info-value"><?= date('d M Y, h:i A') ?></span>
                </div>
                <?php if(isset($_SESSION['last_order_id'])): ?>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-hashtag"></i> Order ID:</span>
                    <span class="info-value"><?= $_SESSION['last_order_id'] ?></span>
                </div>
                <?php endif; ?>
            </div>
            
            <form action="customer_order_history.php">
                <button type="submit" class="return-btn">
                    <i class="fas fa-history"></i> View Order History
                </button>
            </form>
        </div>
    </div>
</body>
</html>