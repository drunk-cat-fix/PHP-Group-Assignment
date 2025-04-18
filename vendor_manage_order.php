<?php
session_start();
require_once 'service/Vendor_Manage_Order.php';
require_once 'vendor_nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor - View Orders</title>
    <style>
        .vendor-orders-wrapper {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .vendor-orders-wrapper h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .vendor-orders-wrapper table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        .vendor-orders-wrapper th, 
        .vendor-orders-wrapper td {
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
            text-align: left;
        }

        .vendor-orders-wrapper th {
            background-color: #f1f3f5;
            color: #495057;
        }

        .vendor-orders-wrapper tr:hover {
            background-color: #f8f9fa;
        }

        .vendor-orders-wrapper .action-btn {
            font-size: 18px;
            cursor: pointer;
            border: none;
            background: none;
            margin: 0 5px;
            transition: transform 0.1s ease-in-out;
        }

        .vendor-orders-wrapper .action-btn:hover {
            transform: scale(1.2);
        }

        .vendor-orders-wrapper .hidden {
            display: none;
        }

        .vendor-orders-wrapper #save-cancel-container {
            margin-top: 20px;
        }

        .vendor-orders-wrapper #save-cancel-container button {
            padding: 8px 14px;
            margin-right: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
        }

        .vendor-orders-wrapper #save-cancel-container button:last-child {
            background-color: #6c757d;
        }

        .vendor-orders-wrapper .debug-container {
            background-color: #fff;
            border: 1px solid #ced4da;
            padding: 10px;
            margin-top: 30px;
            max-height: 300px;
            overflow-y: auto;
            border-radius: 6px;
            font-family: monospace;
            font-size: 13px;
            color: #495057;
        }

        .vendor-orders-wrapper .no-orders {
            color: #777;
            font-size: 16px;
            padding: 20px;
            text-align: center;
        }
    </style>
    <script>
        function handleAccept(button, orderId) {
            document.getElementById("save-cancel-container").classList.remove("hidden");
            document.getElementById("order_id").value = orderId;
            const actionCell = button.parentElement;
            actionCell.innerHTML = "✅ Accepted";
        }

        function handleDeny(button, orderId) {
            const reason = prompt("Please enter the reason for denial:");
            if (reason && confirm("Are you sure you want to deny this order?")) {
                document.getElementById("deny_order_id").value = orderId;
                document.getElementById("deny_reason").value = reason;
                document.getElementById("deny-form").submit();
            }
        }

        function confirmSave() {
            if (confirm("Confirm order completion and update product quantities?")) {
                document.getElementById("update-form").submit();
            }
        }

        function cancelChanges() {
            location.reload();
        }

        function toggleDebug() {
            const debugContainer = document.getElementById("debug-container");
            debugContainer.classList.toggle("hidden");
        }
    </script>
</head>
<body>
    <div class="vendor-orders-wrapper">
        <h2>📋 View Orders</h2>

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
                            <td><?= htmlspecialchars($row['order_id']) ?></td>
                            <td><?= htmlspecialchars($row['products_info']) ?></td>
                            <td>
                                <?php if ($row['status'] !== 'Complete' && $row['status'] !== 'Denied'): ?>
                                    <button class="action-btn" onclick="handleAccept(this, <?= $row['order_id'] ?>)">✅</button>
                                    <button class="action-btn" onclick="handleDeny(this, <?= $row['order_id'] ?>)">❌</button>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="no-orders">No orders found</td>
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

        <!-- Optional: Debug section -->
        <div id="debug-container" class="debug-container hidden">
            <!-- Debug messages can go here -->
        </div>
    </div>
</body>
</html>
