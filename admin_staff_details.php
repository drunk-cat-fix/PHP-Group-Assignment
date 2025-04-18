<?php
session_start();
require_once __DIR__ . '\service\Admin_Staff_Details.php';
require_once 'admin_nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        p {
            font-size: 16px;
            margin: 0;
            color: #555;
        }

        .profile-img {
            width: 120px; /* Increased size */
            height: 120px; /* Increased size */
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
            margin-top: 10px;
        }

        button {
            padding: 12px 20px;
            border: none;
            background-color: #e74c3c;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c0392b;
        }

        .back-link {
            text-align: center;
            display: block;
            margin-top: 20px;
            font-size: 16px;
        }

        .back-link a {
            color: #28a745;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            h2 {
                font-size: 20px;
            }

            button {
                padding: 10px 15px;
            }

            .profile-img {
                width: 100px; /* Adjust size for smaller screens */
                height: 100px; /* Adjust size for smaller screens */
            }
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
        <p><strong>Profile Picture:</strong> <br />
        <?php if (!empty($staff['staff_profile'])): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($staff['staff_profile']) ?>" 
                 alt="Staff Profile" class="profile-img">
        <?php else: ?>
            <span>No image</span>
        <?php endif; ?>
        </p>

        <button type="submit" name="remove_staff">Remove Staff</button>
    </form>

    <div class="back-link">
        <a href="admin_manage_staff.php">Back to Staff List</a>
    </div>
</div>

</body>
</html>
