<?php
session_start();

if (!isset($_SESSION['order'])) {
    echo "No current order found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Tracking</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { 
      font-family: 'Segoe UI', sans-serif; 
      background: #f9f9f9; 
      padding: 20px; 
    }
    .container { 
      max-width: 600px; 
      margin: auto; 
      background: #fff; 
      padding: 20px; 
      box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
      border-radius: 12px; 
      text-align: center; 
    }
    h1 { 
      color: #2e7d32; 
    }
    #order-status { 
      font-size: 1.2em; 
      margin: 20px 0; 
    }
    .btn {
      padding: 10px 20px;
      background: #2196f3;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      text-decoration: none;
    }
    .btn:hover {
      background: #1976d2;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Order Tracking</h1>
    <p>Your tracking number: <strong><?= htmlspecialchars($_SESSION['order']['tracking_number']) ?></strong></p>
    <div id="order-status">Loading current status...</div>
    <a href="index.php" class="btn">Return Home</a>
  </div>
  <script>
    function fetchOrderStatus() {
      fetch('order_status.php')
        .then(response => response.json())
        .then(data => {
          const orderStatusDiv = document.getElementById('order-status');
          orderStatusDiv.textContent = data.status;
          // Stop polling once delivered
          if (data.status === "Delivered") {
            clearInterval(statusInterval);
          }
        })
        .catch(error => console.error('Error fetching order status:', error));
    }
    const statusInterval = setInterval(fetchOrderStatus, 3000);
    fetchOrderStatus();
  </script>
</body>
</html>
