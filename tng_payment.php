<?php
session_start();
$grand_total = $_SESSION['grand_total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Touch 'n Go Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 40px;
        }
        .payment-box {
            display: inline-block;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .qr-code {
            margin: 20px 0;
        }
        .btn-next {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="payment-box">
        <h2>Touch 'n Go Payment</h2>
        <p><strong>Please scan the QR code to pay.</p>

        <div class="qr-code">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=FakeTNGPayment" alt="QR Code">
        </div>

        <form action="payment.php" method="post">
            <input type="hidden" name="order_id" value="<?= $order_id ?>">
            <input type="hidden" name="grand_total" value="<?= $grand_total ?>">
            <input type="hidden" name="confirm_order" value="1"> <!-- ADD THIS -->
            <button type="submit" name="tng" class="btn-next">I Have Paid</button>
        </form>
    </div>
</body>
</html>
