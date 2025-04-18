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
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            padding: 50px 10%;
            margin: 0;
        }

        h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h2 img {
            margin-right: 15px;
            height: 120px; /* Increase the height of the logo */
        }

        .payment-box {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        .bank-info {
            background-color: #f9f9f9;
            border: 1px solid #eee;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            font-size: 14px;
        }

        .bank-info p {
            margin: 8px 0;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .btn-next {
            padding: 12px 20px;
            background-color: #FDB813; /* Maybank Yellow */
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-next:hover {
            background-color: #ffb700; /* Slightly darker yellow on hover */
        }

        /* Responsive design */
        @media (max-width: 768px) {
            body {
                padding: 30px 5%;
            }

            .payment-box {
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }
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
        <h2>
            <img src="https://vectorise.net/logo/wp-content/uploads/2011/09/2011maybanklogo.png" alt="Maybank Logo">
            Bank Transfer Payment
        </h2>

        <div class="bank-info">
            <p><strong>Bank Name:</strong> Maybank</p>
            <p><strong>Account Name:</strong> AgriMarket Solutions Sdn Bhd</p>
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
