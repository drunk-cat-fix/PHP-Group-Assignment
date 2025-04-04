<?php
session_start();
require_once 'service/System_Add_Vendor.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vendor</title>
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
            display: none;
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
            var vendorName = document.getElementById("vendor_name").value;
            var description = document.getElementById("vendor_description").value;
            var shopName = document.getElementById("shop_name").value;
            var shopAddress = document.getElementById("shop_address").value;
            var shopCity = document.getElementById("shop_city").value;
            var shopState = document.getElementById("shop_state").value;
            var profile = document.getElementById("profile").files[0];
            var email = document.getElementById("vendor_email").value;

            // Check if all fields are filled
            if (!vendorName || !description || !shopName || !shopAddress || !shopCity || !shopState || !email) {
                alert("❗ Please fill in all fields.");
                return false;
            }

            // Check if profile picture is uploaded
            if (!profile) {
                alert("📸 Please upload a profile picture.");
                return false;
            }

            // Check if email is valid
            var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailRegex.test(email)) {
                alert("❗ Please enter a valid email address.");
                return false;
            }

            // If everything is valid, show success message and allow form submission
            alert("✅ Vendor added successfully!");
            return true;
        }
    </script>
</head>
<body>
    <h2>Add Vendor</h2>
    <form id="addVendorForm" action="service/System_Add_Vendor.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label for="vendor_name">Vendor Name</label>
        <input type="text" id="vendor_name" name="vendor_name" required>

        <label for="vendor_email">Email</label>
        <input type="email" id="vendor_email" name="vendor_email" required>

        <label for="vendor_description">Description</label>
        <textarea id="vendor_description" name="vendor_description" required></textarea>
        
        <label for="shop_name">Shop Name</label>
        <input type="text" id="shop_name" name="shop_name" required>
        
        <label for="shop_address">Shop Address</label>
        <input type="text" id="shop_address" name="shop_address" required>
        
        <label for="shop_city">Shop City</label>
        <input type="text" id="shop_city" name="shop_city" required>
        
        <label for="shop_state">Shop State</label>
        <input type="text" id="shop_state" name="shop_state" required>

        <label for="profile">Upload Profile Picture</label>
        <input type="file" id="profile" name="profile" accept=".jpeg, .png, .jpg, .bmp" onchange="previewProfile()">
        <img id="profile-preview" src="" alt="Profile Preview">

        <button type="submit">Add Vendor</button>
    </form>
</body>
</html>
