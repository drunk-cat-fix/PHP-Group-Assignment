<?php
session_start();
$grand_total = $_SESSION['grand_total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bank Transfer Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 40px;
            background-color: #f9f9f9;
        }
        .payment-box {
            display: inline-block;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f2f2f2;
            width: 400px;
        }
        .bank-info {
            margin: 20px 0;
            text-align: left;
            line-height: 1.6;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        label {
            float: left;
            font-weight: bold;
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
    <script>
        function validateForm() {
            const bankName = document.getElementById("bank_name").value.trim();
            const accountNumber = document.getElementById("account_number").value.trim();
            const password = document.getElementById("password").value.trim();

            if (bankName === "" || accountNumber === "" || password === "") {
                alert("Please fill in all fields.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="payment-box">
        <h2>Bank Transfer Payment</h2>

        <div class="bank-info">
            <p><strong>Bank Name:</strong> Maybank</p>
            <p><strong>Account Name:</strong> MyCompany Sdn Bhd</p>
            <p><strong>Account Number:</strong> 1234-5678-9012</p>
        </div>

        <form action="payment.php" method="post" onsubmit="return validateForm();">
            <input type="hidden" name="grand_total" value="<?= $grand_total ?>">
            <input type="hidden" name="confirm_order" value="1">

            <label for="bank_name">Your Bank Name:</label>
            <input type="text" id="bank_name" name="user_bank_name" required>

            <label for="account_number">Your Account Number:</label>
            <input type="text" id="account_number" name="user_account_number" required>

            <label for="password">Bank Password:</label>
            <input type="password" id="password" name="user_password" required>

            <button type="submit" name="bank" class="btn-next">Pay</button>
        </form>
    </div>
</body>
</html>
