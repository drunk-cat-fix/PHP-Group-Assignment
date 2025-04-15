<?php
session_start();
require_once 'service/Product_Details.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['product_name']) ?> - Product Details</title>
    <style>
        .product-details {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .product-details img {
            max-width: 100%;
            height: auto;
        }
        .product-details h2 {
            margin-top: 20px;
        }
        .product-details p {
            font-size: 1.1em;
            color: #555;
        }
        .product-details .price {
            font-size: 1.5em;
            color: #333;
        }
        .product-details .form-group {
            margin-top: 20px;
        }
        .product-details input[type="number"] {
            width: 80px;
            padding: 5px;
            font-size: 1em;
        }
        .product-details button {
            padding: 10px 20px;
            font-size: 1em;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .product-details button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="product-details">
    <img src="<?= isset($product['product_profile']) ? 'data:image/jpeg;base64,' . base64_encode($product['product_profile']) : 'path_to_placeholder_image.jpg' ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
    <h2><?= htmlspecialchars($product['product_name']) ?></h2>
    <p><strong>Description:</strong> <?= htmlspecialchars($product['product_desc']) ?></p>
    <p><strong>Category:</strong> <?= htmlspecialchars($product['product_category']) ?></p>
    <p><strong>Quantity Available:</strong> <?= htmlspecialchars($product['product_qty']) ?></p>
    <p><strong>Packaging:</strong> <?= htmlspecialchars($product['product_packaging']) ?></p>
    <p class="price">Price: RM <?= number_format($product['product_price'], 2) ?></p>
    <p><strong>Vendor:</strong> <?= htmlspecialchars($product['vendor_name']) ?></p>
    <p><strong>Rating:</strong> <?= $avg_rating ?></p>

    <!-- Form for selecting quantity and adding to cart -->
    <form method="POST" action="product_details.php?product_id=<?= $product_id ?>">
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= $product['product_qty'] ?>" required>
        </div>
        <input type="hidden" name="product_id" value="<?= $product_id ?>">
        <button type="submit" name="add_to_cart">Add to Cart</button>
    </form>

    <!-- Display message if product is added to cart -->
    <?php if (isset($_SESSION['message'])): ?>
        <p style="color: green;"><?= $_SESSION['message'] ?></p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
</div>

</body>
</html>