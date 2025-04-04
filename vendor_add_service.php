<?php
session_start();
require_once __DIR__. '\service\Vendor_Add_Service.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service</title>
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
            var serviceName = document.getElementById("service_name").value;
            var serviceDescription = document.getElementById("service_desc").value;
            var serviceCategory = document.getElementById("service_category").value;
            var price = document.getElementById("price").value;
            var profile = document.getElementById("profile").files[0];

            // Check if all fields are filled
            if (!serviceName || !serviceDescription || !serviceCategory || !price) {
                alert("❗ Please fill in all fields.");
                return false;
            }

            // Check if profile picture is uploaded
            if (!profile) {
                alert("📸 Please upload a profile picture.");
                return false;
            }

            // If everything is valid, show success message and allow form submission
            alert("✅ Service added successfully!");
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
