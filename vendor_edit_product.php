<?php
session_start();
$_SESSION['vendor_id'] = 3;
require_once 'service/Vendor_Edit_Product.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
            display: <?= !empty($product['product_profile']) ? 'block' : 'none' ?>;
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
            var name = document.getElementById("product_name").value;
            var desc = document.getElementById("product_desc").value;
            var category = document.getElementById("product_category").value;
            var qty = document.getElementById("product_qty").value;
            var packaging = document.getElementById("product_packaging").value;
            var price = document.getElementById("product_price").value;

            if (!name || !desc || !category || !qty || !packaging || !price) {
                alert("❗ Please fill in all fields.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <h2>Edit Product</h2>
    <form method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label for="product_name">Product Name</label>
        <input type="text" id="product_name" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>
        
        <label for="product_desc">Description</label>
        <textarea id="product_desc" name="product_desc" required><?= htmlspecialchars($product['product_desc']) ?></textarea>
        
        <label for="product_category">Category</label>
        <input type="text" id="product_category" name="product_category" value="<?= htmlspecialchars($product['product_category']) ?>" required>
        
        <label for="product_qty">Quantity</label>
        <input type="number" id="product_qty" name="product_qty" value="<?= htmlspecialchars($product['product_qty']) ?>" required>
        
        <label for="product_packaging">Packaging</label>
        <input type="text" id="product_packaging" name="product_packaging" value="<?= htmlspecialchars($product['product_packaging']) ?>" required>
        
        <label for="product_price">Price</label>
        <input type="number" step="0.01" id="product_price" name="product_price" value="<?= htmlspecialchars($product['product_price']) ?>" required>
        
        <label for="profile">Upload Profile Picture</label>
        <input type="file" id="profile" name="profile" accept=".jpeg, .png, .jpg, .bmp" onchange="previewProfile()">
        
        <?php if (!empty($product['product_profile'])): ?>
            <img id="profile-preview" src="data:image/jpeg;base64,<?= base64_encode($product['product_profile']) ?>" alt="Profile Preview">
        <?php else: ?>
            <img id="profile-preview" src="" alt="Profile Preview">
        <?php endif; ?>
        
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
