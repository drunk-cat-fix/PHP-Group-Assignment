<?php
session_start();
require_once 'nav.php';
require_once 'service/Dairy.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dairy</title>
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
            cursor: pointer;
        }
        .product-card h3 {
            margin: 10px 0;
            cursor: pointer;
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
<h1>Crops</h1>
<div class="product-grid">
    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <!-- Clickable image and name that redirects to product_details.php -->
            <a href="product_details.php?product_id=<?= $product['product_id'] ?>">
                <img src="<?= isset($product['product_profile']) ? 'data:image/jpeg;base64,' . base64_encode($product['product_profile']) : 'path_to_placeholder_image.jpg' ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
            </a>
            <a href="product_details.php?product_id=<?= $product['product_id'] ?>">
                <h3><?= htmlspecialchars($product['product_name']) ?></h3>
            </a>
            <?php if ($product['promo_price']): ?>
                <p class="price">
                    <del style="color: #999;">RM <?= number_format($product['product_price'], 2) ?></del>
                    <span style="color: red; font-weight: bold;">RM <?= number_format($product['promo_price'], 2) ?></span>
                </p>
            <?php else: ?>
                <p class="price">Price: RM <?= number_format($product['product_price'], 2) ?></p>
            <?php endif; ?>
            <p class="category">Category: <?= htmlspecialchars($product['product_category']) ?></p>
            <p><?= htmlspecialchars($product['product_desc']) ?></p>
            <p>Rating: <?= $product['avg_rating'] ?></p>
            <p>Quantity left: <?= htmlspecialchars($product['product_qty']) ?></p>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>