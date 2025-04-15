<?php
session_start();
require_once 'nav.php';
require_once 'service/Miscellaneous.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miscellaneous</title>
    <style>
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .product-card {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
        }
        .product-card img {
            max-width: 100%;
            height: auto;
        }
        .product-card h3 {
            margin: 10px 0;
        }
        .product-card .price {
            font-size: 1.2em;
            color: #333;
        }
        .product-card p {
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>

<h1>Miscellaneous</h1>
<div class="product-grid">
    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <!-- If image exists, display it. If not, show placeholder -->
            <img src="<?= isset($product['product_profile']) ? 'data:image/jpeg;base64,' . base64_encode($product['product_profile']) : 'path_to_placeholder_image.jpg' ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
            <h3><?= htmlspecialchars($product['product_name']) ?></h3>
            <p class="price">Price: RM <?= number_format($product['product_price'], 2) ?></p>
            <p class="category">Category: <?= htmlspecialchars($product['product_category']) ?></p>
            <p><?= htmlspecialchars($product['product_desc']) ?></p>
            <p>Rating: <?= htmlspecialchars($product['product_rating']) ?></p>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>