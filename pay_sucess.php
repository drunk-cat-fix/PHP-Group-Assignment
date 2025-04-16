<?php
$buyerName = "Kai Wen";
$amountPaid = "RM50.00";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f9ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .success-box {
            background: #d1e7dd;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #aaa;
            text-align: center;
        }
        .success-box img {
            width: 100px;
            height: 100px;
        }
        h2 {
            color: #0f5132;
            margin-top: 20px;
        }
        p {
            font-size: 18px;
            color: #155724;
            margin: 8px 0;
        }
        .back-button {
            margin-top: 20px;
        }
        .back-button a {
            background-color: #0f5132;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .back-button a:hover {
            background-color: #0c3f28;
        }
    </style>
</head>
<body>
    <div class="success-box">
        <img src="https://cdn-icons-png.freepik.com/256/16019/16019809.png?semt=ais_hybrid" alt="Success Icon">
        <h2>Payment Successfully</h2>
        <p><strong>Name of Buyer:</strong> <?php echo $buyerName; ?></p>
        <p><strong>Amount Paid:</strong> <?php echo $amountPaid; ?></p>
        <div class="back-button">
            <a href="index.php">Back to Home</a>
        </div>
    </div>
</body>
</html>
