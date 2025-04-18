<?php
session_start();
require_once __DIR__ . '/service/Admin_Manage_Staff.php';
require_once 'admin_nav.php';
if ($_POST) {
    $staff_name = $_POST['staff_name'];
    $staff_email = $_POST['staff_email'];
    $staff_password = $_POST['staff_password'];
    $hashed_password = password_hash($staff_password, PASSWORD_DEFAULT);
    $staff_address = $_POST['staff_address'];
    $staff_profile = file_get_contents($_FILES["avatar"]["tmp_name"]);
    $staff_profile=addslashes($staff_profile);
    $mimeType = $_FILES["avatar"]["type"];

    $allowed = ["image/jpeg", "image/png", "image/gif", "image/webp","image/jpg"];
    if (!in_array($mimeType, $allowed)) {
        die("Unsupported image format");
    }

    if (createStaff($staff_name, $hashed_password, $staff_address, $staff_email, $staff_profile)) {
        echo "<script language='javascript' type='text/javascript'>alert('Create Staff Successfully !')</script>";
        echo "<script language='javascript' type='text/javascript'>window.location = 'admin_manage_staff.php';</script>";
    } else {
        echo "<script language='javascript' type='text/javascript'>alert('Create Failed !')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Staff</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        button {
            padding: 10px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        th, td {
            padding: 12px;
            border: 1px solid #e0e0e0;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 30px;
            border-radius: 8px;
            width: 500px;
            max-width: 90%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        .modal-content h3 {
            margin-top: 0;
        }

        .modal-content form label {
            display: block;
            margin: 12px 0 6px;
        }

        .modal-content form input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .modal-content form button {
            margin-top: 15px;
            background-color: #28a745;
        }

        .modal-content form button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>Admin - Manage Staff</h2>

    <!-- Add Staff Button -->
    <button id="addStaffBtn">➕ Add Staff</button>

    <!-- Modal for adding staff -->
    <div id="staffModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Add New Staff</h3>
            <form action="admin_manage_staff.php" method="POST" enctype="multipart/form-data">
                <label for="staff_name">Staff Name</label>
                <input type="text" id="staff_name" name="staff_name" required>

                <label for="staff_email">Email</label>
                <input type="email" id="staff_email" name="staff_email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="staff_password" required>

                <label for="staff_address">Address</label>
                <input type="text" id="staff_address" name="staff_address" required>

                <label for="avatar">Profile Picture</label>
                <input type="file" id="avatar" name="avatar" accept="image/*" required>

                <button type="submit">Add Staff</button>
            </form>
        </div>
    </div>

    <!-- Staff Table -->
    <table>
        <thead>
        <tr>
            <th>Staff ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Assigned</th>
            <th>Completed</th>
            <th>Overdue</th>
            <th>Rate</th>
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
                    <td><?= $staff['tasks_assigned'] ?></td>
                    <td><?= $staff['tasks_completed'] ?></td>
                    <td><?= $staff['overdue_tasks'] ?></td>
                    <td><?= $staff['completion_rate'] ?>%</td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No staff found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <script>
        var modal = document.getElementById("staffModal");
        var btn = document.getElementById("addStaffBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function () {
            modal.style.display = "block";
        }

        span.onclick = function () {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

<script>
    // Modal functionality
    var modal = document.getElementById("staffModal");
    var btn = document.getElementById("addStaffBtn");
    var span = document.getElementsByClassName("close")[0];

    // Open the modal when the button is clicked
    btn.onclick = function () {
        modal.style.display = "block";
    }

    // Close the modal when the user clicks the close button
    span.onclick = function () {
        modal.style.display = "none";
    }

    // Close the modal if the user clicks outside of the modal
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</html>
