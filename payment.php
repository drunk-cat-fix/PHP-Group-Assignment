<?php
session_start();
require_once 'service/Payment.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #2e7d32; }
        .total { font-weight: bold; font-size: 1.2em; margin-top: 20px; padding-top: 10px; border-top: 1px solid #ccc; text-align: right; }
        .payment-form { margin-top: 30px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .pay-btn { background-color: #4caf50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
        .pay-btn:hover { background-color: #388e3c; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment</h1>

        <div class="total">Grand Total: RM <?= number_format($grand_total, 2) ?></div>

        <form class="payment-form" method="POST">
            <!-- Include hidden total in POST -->
            <input type="hidden" name="grand_total" value="<?= $grand_total ?>">
            <input type="hidden" name="confirm_order" value="1">

            <div class="form-group">
                <label for="name">Cardholder Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="card">Card Number</label>
                <input type="text" id="card" name="card" required>
            </div>
            <div class="form-group">
                <label for="expiry">Expiry Date</label>
                <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" required>
            </div>
            <button type="submit" class="pay-btn">Complete Payment</button>
        </form>
    </div>
</body>
</html>
