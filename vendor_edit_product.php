<?php
session_start();
if (!isset($_SESSION['vendor_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'vendor_nav.php';
require_once 'service/Vendor_Edit_Product.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .content-wrapper {
            max-width: 700px;
            margin: 80px auto 40px auto;
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
            display: <?= !empty($product['product_profile']) ? 'block' : 'none' ?>;
        }

        button[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #218838;
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
    <div class="content-wrapper">
        <h2>Edit Product</h2>
        <form method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <label for="product_name">Product Name</label>
            <input type="text" id="product_name" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>

            <label for="product_desc">Description</label>
            <textarea id="product_desc" name="product_desc" rows="4" required><?= htmlspecialchars($product['product_desc']) ?></textarea>

            <label for="product_category">Category</label>
            <input type="text" id="product_category" name="product_category" value="<?= htmlspecialchars($product['product_category']) ?>" required>

            <label for="product_qty">Quantity</label>
            <input type="number" id="product_qty" name="product_qty" value="<?= htmlspecialchars($product['product_qty']) ?>" required>

            <label for="product_packaging">Packaging</label>
            <input type="text" id="product_packaging" name="product_packaging" value="<?= htmlspecialchars($product['product_packaging']) ?>" required>

            <label for="product_price">Price (RM)</label>
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
    </div>
</body>
</html>
