<?php
session_start();
require_once __DIR__. '\service\Admin_Staff_Details.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        button {
            padding: 8px 12px;
            border: none;
            background-color: red;
            color: white;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Staff Details</h2>
    <form method="POST" action="service/Admin_Staff_details.php" onsubmit="return confirm('Are you sure you want to remove this staff member?');">
        <input type="hidden" name="staff_id" value="<?= htmlspecialchars($staff['staff_id']) ?>">
        <p><strong>ID:</strong> <?= htmlspecialchars($staff['staff_id']) ?></p>
        <p><strong>Name:</strong> <?= htmlspecialchars($staff['staff_name']) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($staff['staff_address']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($staff['staff_email']) ?></p>
        <p><strong>Profile Picture:</strong>
        <?php if (!empty($staff['staff_profile'])): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($staff['staff_profile']) ?>" 
                 alt="Staff Profile" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
        <?php else: ?>
            <span>No image</span>
        <?php endif; ?>
        </p>
        <button type="submit" name="remove_staff">Remove Staff</button>
    </form>

    <br>
    <a href="admin_dashboard.php">Back to Staff List</a>
</div>

</body>
</html>
