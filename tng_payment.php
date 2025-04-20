<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'nav.php';
$grand_total = $_SESSION['grand_total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touch 'n Go Payment | AgriMarket Solutions</title>
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

        .header, .navbar {
            position: relative;
            z-index: 9999;
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
            max-width: 1200px;
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

        .payment-box {
            background-color: var(--white);
            padding: 30px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
            transition: var(--transition);
        }

        .payment-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .payment-box h2 {
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .payment-box p {
            color: var(--dark-gray);
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .qr-code {
            margin: 20px 0;
        }

        .qr-code img {
            width: 200px;
            height: 200px;
            border: 1px solid var(--medium-gray);
            border-radius: 8px;
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

            .payment-box {
                padding: 20px;
            }

            .qr-code img {
                width: 150px;
                height: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container" style="box-shadow: none; margin-bottom: 0;">
            <h1>Touch 'n Go Payment</h1>
            <p class="subtitle">Complete your purchase securely with Touch 'n Go</p>
        </div>
    </div>

    <div class="container">
        <div class="summary-card">
            <div class="summary-icon"><i class="fas fa-wallet"></i></div>
            <div class="summary-title">Total Amount</div>
            <div class="summary-value">RM <?= number_format($grand_total, 2) ?></div>
        </div>

        <div class="payment-box">
            <h2>Touch 'n Go Payment</h2>
            <p><strong>Please scan the QR code to pay.</strong></p>
            <div class="qr-code">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=FakeTNGPayment" alt="QR Code">
            </div>
            <form action="payment.php" method="post">
                <input type="hidden" name="order_id" value="<?= $order_id ?>">
                <input type="hidden" name="grand_total" value="<?= $grand_total ?>">
                <input type="hidden" name="confirm_order" value="1">
                <button type="submit" name="tng" class="pay-btn">
                    <i class="fas fa-check-circle"></i> I Have Paid
                </button>
            </form>
        </div>
    </div>
</body>
</html>