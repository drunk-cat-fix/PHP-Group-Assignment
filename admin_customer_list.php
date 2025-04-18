<?php
session_start();
require_once 'service/Admin_Customer_List.php';
require_once 'admin_nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer List</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f4f6f8;
        margin: 0;
        padding: 30px;
    }

    .container {
        max-width: 1200px;
        margin: auto;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 30px;
    }

    .table-container {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 12px;
        overflow: hidden;
        min-width: 800px;
    }

    th, td {
        padding: 14px 16px;
        text-align: left;
    }

    th {
        background-color: #3498db;
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 14px;
    }

    tr:nth-child(even) {
        background-color: #f2f6fc;
    }

    tr:hover {
        background-color: #e9f3ff;
    }

    td {
        color: #333;
        vertical-align: middle;
        font-size: 15px;
    }

    img.profile {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }

    .no-img {
        font-style: italic;
        color: #888;
    }
</style>
</head>
<body>
    <div class="container">
        <h2>👤 Customer List</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $cust): ?>
                        <tr>
                            <td>
                                <?php if (!empty($cust['customer_profile'])): ?>
                                    <img class="profile" src="data:image/jpeg;base64,<?= base64_encode($cust['customer_profile']) ?>" alt="Profile">
                                <?php else: ?>
                                    <span class="no-img">No Image</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($cust['customer_id']) ?></td>
                            <td><?= htmlspecialchars($cust['customer_name']) ?></td>
                            <td><?= htmlspecialchars($cust['customer_email']) ?></td>
                            <td><?= htmlspecialchars($cust['customer_address']) ?></td>
                            <td><?= htmlspecialchars($cust['customer_city']) ?></td>
                            <td><?= htmlspecialchars($cust['customer_state']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>