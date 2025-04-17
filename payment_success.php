<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 40px;
            background-color: #e9ffe9;
        }
        .success-box {
            display: inline-block;
            padding: 30px;
            border: 2px solid #4CAF50;
            border-radius: 10px;
            background-color: #ffffff;
        }
        .btn-return {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #008CBA;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="success-box">
        <h2>Payment Successful</h2>
        <p>Your payment for the order has been received.</p>

        <form action="customer_order_history.php">
            <button type="submit" class="btn-return">Return to Order History</button>
        </form>
    </div>
</body>
</html>
