<?php
session_start();
$_SESSION['vendor_id'] = 3;
require_once 'service/Vendor_Edit_Service.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <style>
        form {
            width: 50%;
            margin: auto;
            display: flex;
            flex-direction: column;
        }
        label, input, select, textarea {
            margin-bottom: 10px;
        }
        img {
            max-width: 100px;
            display: <?= !empty($service['service_profile']) ? 'block' : 'none' ?>;
        }
    </style>
    <script>
        function previewProfile() {
            var file = document.getElementById("profile").files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                var img = document.getElementById("profile-preview");
                img.src = e.target.result;
                img.style.display = "block";
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        function validateForm() {
            var name = document.getElementById("service_name").value;
            var desc = document.getElementById("service_desc").value;
            var category = document.getElementById("service_category").value;
            var price = document.getElementById("service_price").value;

            if (!name || !desc || !category || !price) {
                alert("❗ Please fill in all fields.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <h2>Edit Service</h2>
    <form method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label for="service_name">Service Name</label>
        <input type="text" id="service_name" name="service_name" value="<?= htmlspecialchars($service['service_name']) ?>" required>
        
        <label for="service_desc">Description</label>
        <textarea id="service_desc" name="service_desc" required><?= htmlspecialchars($service['service_desc']) ?></textarea>
        
        <label for="service_category">Category</label>
        <input type="text" id="service_category" name="service_category" value="<?= htmlspecialchars($service['service_category']) ?>" required>
        
        <label for="service_price">Price</label>
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
</body>
</html>
