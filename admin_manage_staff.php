<?php
session_start();
require_once __DIR__ . '/service/Admin_Manage_Staff.php';
//require_once __DIR__ . '/Utilities/Upload.php';
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

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        input[type="text"], input[type="email"], input[type="file"], input[type=password] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ddd;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<h2>Admin Manage Staff</h2>

<!-- Add Staff Button -->
<button id="addStaffBtn">Add Staff</button>

<!-- Modal for adding staff -->
<div id="staffModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Add New Staff</h3>
        <form action="admin_manage_staff.php" method="POST" enctype="multipart/form-data">
            <label for="staff_name">Staff Name:</label>
            <input type="text" id="staff_name" name="staff_name" required><br>

            <label for="password">Password: </label>
            <input id="password" type="password" name="password" required><br>

            <label for="staff_address">Address:</label>
            <input type="text" id="staff_address" name="staff_address" required><br>

            <label for="staff_email">Email:</label>
            <input type="email" id="staff_email" name="staff_email" required><br>

            <label for="staff_profile">Profile Picture:</label>
            <input type="file" id="staff_profile" name="avatar"><br>

            <button type="submit">Add Staff</button>
        </form>
    </div>
</div>

<!-- Staff Table -->
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
                        <img src="data:image/jpeg;base64,<?= base64_encode(stripslashes($staff['staff_profile'])) ?>"
                             alt="Staff Profile"
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
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
</body>
</html>
