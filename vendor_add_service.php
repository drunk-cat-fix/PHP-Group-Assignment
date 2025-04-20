<?php
require_once __DIR__ . '\service\Vendor_Add_Service.php';
if (!isset($_SESSION['vendor_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'vendor_nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        form {
            width: 50%;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #444;
        }
        input, select, textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        img {
            max-width: 120px;
            margin-top: 10px;
            display: none;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        button {
            margin-top: 20px;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
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
            const serviceName = document.getElementById("service_name").value.trim();
            const serviceDescription = document.getElementById("service_desc").value.trim();
            const serviceCategory = document.getElementById("service_category").value.trim();
            const price = document.getElementById("price").value.trim();
            const profile = document.getElementById("profile").files[0];

            if (!serviceName || !serviceDescription || !serviceCategory || !price) {
                alert("❗ Please fill in all fields.");
                return false;
            }

            if (!profile) {
                alert("📸 Please upload a profile picture.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <h2>Add Service</h2>
    <form id="addServiceForm" action="service/Vendor_Add_Service.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label for="service_name">Service Name</label>
        <input type="text" id="service_name" name="service_name">

        <label for="service_desc">Description</label>
        <textarea id="service_desc" name="service_desc"></textarea>

        <label for="service_category">Category</label>
        <input type="text" id="service_category" name="service_category">

        <label for="price">Price</label>
        <input type="number" step="0.01" id="price" name="price">

        <label for="profile">Upload Profile Picture</label>
        <input type="file" id="profile" name="profile" accept=".jpeg, .png, .jpg, .bmp" onchange="previewProfile()">
        <img id="profile-preview" src="" alt="Profile Preview">

        <button type="submit">Add Service</button>
    </form>
</body>
</html>
