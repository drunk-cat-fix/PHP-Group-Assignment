<?php
session_start();
require_once 'service/Admin_Customer_List.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        img.profile {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <h2>Customer List</h2>

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
                            <span>No Image</span>
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
</body>
</html>