<?php
session_start();
require_once __DIR__. '\service\Vendor_Add_Product.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
            var productName = document.getElementById("product_name").value;
            var productDescription = document.getElementById("product_desc").value;
            var productCategory = document.getElementById("product_category").value;
            var quantity = document.getElementById("quantity").value;
            var productPackaging = document.getElementById("product_packaging").value;
            var price = document.getElementById("price").value;
            var profile = document.getElementById("profile").files[0];

            // Check if all fields are filled
            if (!productName || !productDescription || !productCategory || !quantity || !productPackaging || !price) {
                alert("❗ Please fill in all fields.");
                return false;
            }

            // Check if profile picture is uploaded
            if (!profile) {
                alert("📸 Please upload a profile picture.");
                return false;
            }

            // If everything is valid, show success message and allow form submission
            alert("✅ Product added successfully!");
            return true;
        }
    </script>
</head>
<body>
    <h2>Add Product</h2>
    <form id="addProductForm" action="service/Vendor_Add_Product.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label for="product_name">Product Name</label>
        <input type="text" id="product_name" name="product_name">
        
        <label for="product_desc">Description</label>
        <textarea id="product_desc" name="product_desc"></textarea>
        
        <label for="product_category">Category</label>
        <input type="text" id="product_category" name="product_category">
        
        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" name="quantity">
        
        <label for="product_packaging">Packaging</label>
        <input type="text" id="product_packaging" name="product_packaging">
        
        <label for="price">Price</label>
        <input type="number" step="0.01" id="price" name="price">
        
        <label for="profile">Upload Profile Picture</label>
        <input type="file" id="profile" name="profile" accept=".jpeg, .png, .jpg, .bmp" onchange="previewProfile()">
        <img id="profile-preview" src="" alt="Profile Preview">
        
        <button type="submit">Add Product</button>
    </form>
</body>
</html>
