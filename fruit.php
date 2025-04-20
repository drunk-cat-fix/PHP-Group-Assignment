<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'nav.php';
require_once 'service/Fruit.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruit Listing | AgriMarket Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #45a049;
            --accent-color: #ff6b6b;
            --light-gray: #f5f5f5;
            --medium-gray: #ddd;
            --dark-gray: #666;
            --text-color: #333;
            --white: #fff;
            --shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light-gray);
            color: var(--text-color);
            line-height: 1.6;
        }

        .page-header {
            background-color: var(--white);
            padding: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        h1 {
            color: var(--primary-color);
            text-align: center;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: var(--dark-gray);
            margin-bottom: 20px;
            font-size: 1rem;
        }

        .search-container {
            background-color: var(--white);
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .search-form {
            display: flex;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid var(--medium-gray);
            border-radius: 4px 0 0 4px;
            font-size: 16px;
            transition: var(--transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .search-btn {
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 0 20px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: var(--transition);
            font-size: 16px;
        }

        .search-btn:hover {
            background-color: var(--secondary-color);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
            padding: 10px 0;
        }

        .product-card {
            background-color: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-category {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(76, 175, 80, 0.85);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .product-info {
            padding: 15px;
        }

        .product-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-color);
            text-decoration: none;
            display: block;
            transition: var(--transition);
        }

        .product-name:hover {
            color: var(--primary-color);
        }

        .product-desc {
            color: var(--dark-gray);
            font-size: 0.9rem;
            margin-bottom: 12px;
            height: 40px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 0.9rem;
        }

        .product-rating {
            display: flex;
            align-items: center;
            color: #ffa41c;
        }

        .product-rating i {
            margin-right: 3px;
        }

        .product-stock {
            color: var(--dark-gray);
        }

        .stock-low {
            color: var(--accent-color);
        }

        .product-price {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .regular-price {
            color: var(--text-color);
            font-size: 1.1rem;
            font-weight: 600;
        }

        .sale-price {
            display: flex;
            align-items: center;
        }

        .original-price {
            color: var(--dark-gray);
            text-decoration: line-through;
            font-size: 0.9rem;
            margin-right: 8px;
        }

        .discount-price {
            color: var(--accent-color);
            font-size: 1.2rem;
            font-weight: 600;
        }

        .product-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .view-btn, .add-to-cart-btn {
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
            transition: var(--transition);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .view-btn {
            background-color: var(--light-gray);
            color: var(--text-color);
            flex: 1;
            margin-right: 8px;
            border: 1px solid var(--medium-gray);
        }

        .view-btn:hover {
            background-color: var(--medium-gray);
        }

        .add-to-cart-btn {
            background-color: var(--primary-color);
            color: var(--white);
            flex: 2;
            border: none;
            cursor: pointer;
        }

        .add-to-cart-btn:hover {
            background-color: var(--secondary-color);
        }

        .no-results {
            text-align: center;
            padding: 40px 0;
            font-size: 1.2rem;
            color: var(--dark-gray);
        }

        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 15px;
            }

            .search-form {
                flex-direction: column;
            }

            .search-input {
                border-radius: 4px;
                margin-bottom: 10px;
            }

            .search-btn {
                border-radius: 4px;
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .product-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .product-image {
                height: 160px;
            }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <h1>Fruits List</h1>
            <p class="subtitle">Savor juicy, farm-fresh fruits bursting with flavor.</p>
        </div>
    </div>

    <div class="container">
        <div class="search-container">
            <form method="get" action="fruit.php" class="search-form">
                <input type="text" name="query" class="search-input" placeholder="Search for fruits..." 
                    value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>

        <?php if (empty($products)): ?>
            <div class="no-results">
                <i class="fas fa-search" style="font-size: 3rem; color: #ccc; display: block; margin-bottom: 20px;"></i>
                <p>No fruits found. Please try a different search term.</p>
            </div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <a href="product_details.php?product_id=<?= $product['product_id'] ?>">
                                <img src="<?= isset($product['product_profile']) ? 'data:image/jpeg;base64,' . base64_encode($product['product_profile']) : 'path_to_placeholder_image.jpg' ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                            </a>
                            <span class="product-category"><?= htmlspecialchars($product['product_category']) ?></span>
                        </div>
                        
                        <div class="product-info">
                            <a href="product_details.php?product_id=<?= $product['product_id'] ?>" class="product-name">
                                <?= htmlspecialchars($product['product_name']) ?>
                            </a>
                            
                            <p class="product-desc"><?= htmlspecialchars($product['product_desc']) ?></p>
                            
                            <div class="product-meta">
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <?php if (is_numeric($product['avg_rating'])): ?>
                                        <span><?= number_format((float)$product['avg_rating'], 1) ?></span>
                                    <?php else: ?>
                                        <span>No ratings yet</span>
                                    <?php endif; ?>
                                </div>
    
                                <div class="product-stock <?= $product['product_qty'] < 10 ? 'stock-low' : '' ?>">
                                    <?php if ($product['product_qty'] < 5): ?>
                                        <i class="fas fa-exclamation-circle"></i> Only <?= $product['product_qty'] ?> left
                                    <?php else: ?>
                                        <i class="fas fa-check-circle"></i> In Stock (<?= $product['product_qty'] ?>)
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="product-price">
                                <?php if ($product['promo_price']): ?>
                                    <div class="sale-price">
                                        <span class="original-price">RM <?= number_format($product['product_price'], 2) ?></span>
                                        <span class="discount-price">RM <?= number_format($product['promo_price'], 2) ?></span>
                                    </div>
                                <?php else: ?>
                                    <span class="regular-price">RM <?= number_format($product['product_price'], 2) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        function addToCart(productId) {
            alert('Product added to cart!');
        }
    </script>
</body>
</html>