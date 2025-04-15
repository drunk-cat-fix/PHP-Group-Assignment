<?php
session_start();
require_once __DIR__ . '/service/Admin_Manage_Staff.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Staff</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .task-section {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h2>Admin Manage Staff</h2>
    <table>
        <thead>
            <tr>
                <th>Staff ID</th>
                <th>Staff Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Profile Picture</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($staffList)): ?>
                <?php foreach ($staffList as $staff): ?>
                    <tr>
                        <td><?= htmlspecialchars($staff['staff_id']) ?></td>
                        <td>
                            <a href="admin_staff_details.php?id=<?= htmlspecialchars($staff['staff_id']) ?>">
                                <?= htmlspecialchars($staff['staff_name']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($staff['staff_address']) ?></td>
                        <td><?= htmlspecialchars($staff['staff_email']) ?></td>
                        <td>
                            <?php if (!empty($staff['staff_profile'])): ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($staff['staff_profile']) ?>" 
                                     alt="Staff Profile" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                            <?php else: ?>
                                <span>No image</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No staff found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
