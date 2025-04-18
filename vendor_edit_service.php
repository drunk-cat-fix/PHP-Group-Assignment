<?php
session_start();
require_once 'service/Vendor_Edit_Service.php';
require_once 'vendor_nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .content-wrapper {
            max-width: 700px;
            margin: 80px auto 40px auto; /* space below navbar */
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 6px;
            font-weight: bold;
            color: #444;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 18px;
            resize: vertical;
        }

        input[type="file"] {
            margin-bottom: 18px;
        }

        img {
            max-width: 120px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
            display: <?= !empty($service['service_profile']) ? 'block' : 'none' ?>;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        @media screen and (max-width: 768px) {
            .content-wrapper {
                margin: 80px 10px 40px 10px;
                padding: 15px;
            }
        }
    </style>
    <script>
        function previewProfile() {
            const file = document.getElementById("profile").files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                const img = document.getElementById("profile-preview");
                img.src = e.target.result;
                img.style.display = "block";
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        function validateForm() {
            const name = document.getElementById("service_name").value;
            const desc = document.getElementById("service_desc").value;
            const category = document.getElementById("service_category").value;
            const price = document.getElementById("service_price").value;

            if (!name || !desc || !category || !price) {
                alert("❗ Please fill in all fields.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="content-wrapper">
        <h2>Edit Service</h2>
        <form method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <label for="service_name">Service Name</label>
            <input type="text" id="service_name" name="service_name" value="<?= htmlspecialchars($service['service_name']) ?>" required>

            <label for="service_desc">Description</label>
            <textarea id="service_desc" name="service_desc" rows="4" required><?= htmlspecialchars($service['service_desc']) ?></textarea>

            <label for="service_category">Category</label>
            <input type="text" id="service_category" name="service_category" value="<?= htmlspecialchars($service['service_category']) ?>" required>

            <label for="service_price">Price (RM)</label>
            <input type="number" step="0.01" id="service_price" name="service_price" value="<?= htmlspecialchars($service['service_price']) ?>" required>

            <label for="profile">Upload Profile Picture</label>
            <input type="file" id="profile" name="profile" accept=".jpeg, .png, .jpg, .bmp" onchange="previewProfile()">

            <?php if (!empty($service['service_profile'])): ?>
                <img id="profile-preview" src="data:image/jpeg;base64,<?= base64_encode($service['service_profile']) ?>" alt="Profile Preview">
            <?php else: ?>
                <img id="profile-preview" src="" alt="Profile Preview">
            <?php endif; ?>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
