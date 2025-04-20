<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'service/Payment.php';
require_once 'nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment | AgriMarket Solutions</title>
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
        
        .payment-form {
            margin-top: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-gray);
        }
        
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--medium-gray);
            border-radius: 6px;
            transition: var(--transition);
            font-size: 1rem;
        }
        
        input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
        }
        
        .pay-btn {
            display: block;
            width: 100%;
            background-color: var(--primary-color);
            color: var(--white);
            padding: 14px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }
        
        .pay-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .payment-methods {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }
        
        .payment-icon {
            font-size: 1.5rem;
            margin: 0 8px;
            color: var(--dark-gray);
        }
        
        .form-row {
            display: flex;
            gap: 15px;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container" style="box-shadow: none; margin-bottom: 0;">
            <h1>Payment</h1>
            <p class="subtitle">Complete your purchase securely</p>
        </div>
    </div>

    <div class="container">
        <div class="summary-card">
            <div class="summary-icon"><i class="fas fa-shopping-cart"></i></div>
            <div class="summary-title">Total Amount</div>
            <div class="summary-value">RM <?= number_format($grand_total, 2) ?></div>
        </div>
        
        <div class="payment-methods">
            <i class="fab fa-cc-visa payment-icon"></i>
            <i class="fab fa-cc-mastercard payment-icon"></i>
            <i class="fab fa-cc-amex payment-icon"></i>
            <i class="fab fa-cc-discover payment-icon"></i>
        </div>
        
        <form class="payment-form" method="POST">
            <!-- Include hidden total in POST -->
            <input type="hidden" name="grand_total" value="<?= $grand_total ?>">
            <input type="hidden" name="confirm_order" value="1">
            
            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Cardholder Name</label>
                <input type="text" id="name" name="name" required placeholder="Enter cardholder's full name">
            </div>
            
            <div class="form-group">
                <label for="card"><i class="fas fa-credit-card"></i> Card Number</label>
                <input type="text" id="card" name="card" required placeholder="XXXX XXXX XXXX XXXX">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="expiry"><i class="far fa-calendar-alt"></i> Expiry Date</label>
                    <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
                </div>
                
                <div class="form-group">
                    <label for="cvv"><i class="fas fa-lock"></i> CVV</label>
                    <input type="text" id="cvv" name="cvv" required placeholder="XXX">
                </div>
            </div>
            
            <button type="submit" class="pay-btn">
                <i class="fas fa-lock"></i> Complete Payment
            </button>
        </form>
    </div>
</body>
</html>