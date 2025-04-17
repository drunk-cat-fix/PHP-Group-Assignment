<?php
session_start();
$_SESSION['vendor_id'] = 3;
require_once 'service/Vendor_Manage_Order.php';
require_once 'service/Vendor_Notification.php';
$notificationCount = count($notifications);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor - View Orders</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .hidden {
            display: none;
        }
        .action-btn {
            font-size: 20px;
            cursor: pointer;
            border: none;
            background: none;
            margin: 0 5px;
        }
        .debug-container {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            padding: 10px;
            margin-top: 20px;
            max-height: 300px;
            overflow-y: auto;
        }
        .debug-message {
            margin: 5px 0;
            font-family: monospace;
        }
        .notification {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
        }
        .notification .badge {
            position: absolute;
            top: -10px;
            right: -10px;
            padding: 5px 8px;
            border-radius: 50%;
            background: red;
            color: white;
            font-size: 12px;
        }
    </style>
    <script>
        function handleAccept(button, orderId) {
            // Show the confirm button container
            document.getElementById("save-cancel-container").classList.remove("hidden");
            
            // Store the order ID in the hidden input field for form submission
            document.getElementById("order_id").value = orderId;
            
            // Change the action cell text
            const actionCell = button.parentElement;
            actionCell.innerHTML = "✅ Accepted";
        }

        function handleDeny(button, orderId) {
            const reason = prompt("Please enter the reason for denial:");
            if (reason) {
                if (confirm("Are you sure you want to deny this order?")) {
                    document.getElementById("deny_order_id").value = orderId;
                    document.getElementById("deny_reason").value = reason;
                    document.getElementById("deny-form").submit();
                }
            }
        }

        function confirmSave() {
            if (confirm("Are you sure you want to save this change? This will mark the order as complete and update product quantities.")) {
                document.getElementById("update-form").submit();
            }
        }

        function cancelChanges() {
            location.reload();
        }
        
        function toggleDebug() {
            const debugContainer = document.getElementById("debug-container");
            if (debugContainer.classList.contains("hidden")) {
                debugContainer.classList.remove("hidden");
            } else {
                debugContainer.classList.add("hidden");
            }
        }
    </script>
</head>
<body>
    <a href="vendor_notifications_page.php" class="notification">
        🔔<span class="badge"><?= $notificationCount ?></span>
    </a>
    <h2>Vendor - View Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Products</th>
                <th>Action</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($result)): ?>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo $row['order_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['products_info']); ?></td>
                        <td>
                            <?php if ($row['status'] !== 'Complete' && $row['status'] !== 'Denied'): ?>
                                <button class="action-btn" onclick="handleAccept(this, <?php echo $row['order_id']; ?>)">✅</button>
                                <button class="action-btn" onclick="handleDeny(this, <?php echo $row['order_id']; ?>)">❌</button>
                            <?php else: ?>
                                <?php echo "-"; ?>
                            <?php endif; ?>
                        </td>
                        <td class="status-cell"><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No orders found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div id="save-cancel-container" class="hidden">
        <form id="update-form" method="POST">
            <input type="hidden" name="action" value="update_status">
            <input type="hidden" id="order_id" name="order_id" value="">
        </form>
        <form id="deny-form" method="POST">
            <input type="hidden" name="action" value="deny_order">
            <input type="hidden" id="deny_order_id" name="order_id" value="">
            <input type="hidden" id="deny_reason" name="reason" value="">
        </form>
        <button onclick="confirmSave()">Confirm</button>
        <button onclick="cancelChanges()">Cancel</button>
    </div>
</body>
</html>