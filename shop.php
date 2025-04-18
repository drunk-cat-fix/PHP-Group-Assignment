<?php
session_start();
require_once 'nav.php';
require_once 'service/Shop.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($vendor['shop_name']) ?> | AgriMarket Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            --blue: #2196F3;
            --yellow: #FFD700;
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

        .header, .navbar {
            position: relative;
            z-index: 9999;
        }

        .page-header {
            background-color: var(--white);
            padding: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            margin-top: 20px;
            z-index: 1;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: var(--primary-color);
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: var(--dark-gray);
            margin-bottom: 20px;
            font-size: 1.1rem;
            font-style: italic;
        }

        .vendor-card {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 30px;
            margin-bottom: 40px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            transition: var(--transition);
        }

        .vendor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .vendor-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid var(--medium-gray);
        }

        .vendor-details {
            flex: 1;
            min-width: 250px;
        }

        .vendor-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
            padding: 15px;
            background-color: var(--light-gray);
            border-radius: 8px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            font-size: 1rem;
        }

        .meta-icon {
            color: var(--primary-color);
            margin-right: 10px;
            font-size: 1.3rem;
        }

        .meta-label {
            font-weight: 600;
            margin-right: 5px;
        }

        .vendor-actions {
            margin-top: 20px;
        }

        .rate-vendor-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--blue);
            color: var(--white);
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .rate-vendor-btn:hover {
            background-color: #1976D2;
            transform: translateY(-2px);
        }

        .search-container {
            margin: 30px 0;
            padding: 20px;
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .search-form {
            display: flex;
            gap: 10px;
            align-items: center;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-input {
            flex: 1;
            padding: 12px;
            border: 1px solid var(--medium-gray);
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }

        .search-btn {
            padding: 12px 20px;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .search-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }

        .product-card {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            position: relative;
            width: 100%;
            height: 200px;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-bottom: 1px solid var(--medium-gray);
        }

        .product-category {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: var(--primary-color);
            color: var(--white);
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .product-info {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-name {
            font-size: 1.5rem;
            color: var(--primary-color);
            text-decoration: none;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .product-name:hover {
            color: var(--secondary-color);
        }

        .product-desc {
            font-size: 0.95rem;
            color: var(--dark-gray);
            margin-bottom: 15px;
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: var(--dark-gray);
        }

        .product-rating i {
            color: var(--yellow);
            margin-right: 5px;
        }

        .product-stock i {
            color: var(--primary-color);
            margin-right: 5px;
        }

        .product-price {
            margin-bottom: 15px;
        }

        .original-price {
            color: var(--dark-gray);
            text-decoration: line-through;
            font-size: 0.95rem;
            margin-right: 10px;
        }

        .promo-price {
            color: var(--accent-color);
            font-size: 1.3rem;
            font-weight: bold;
        }

        .product-price span {
            color: var(--primary-color);
            font-size: 1.3rem;
            font-weight: bold;
        }

        .product-actions {
            display: flex;
            gap: 10px;
        }

        .view-btn, .add-to-cart-btn {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .view-btn {
            background-color: var(--blue);
            color: var(--white);
        }

        .view-btn:hover {
            background-color: #1976D2;
            transform: translateY(-2px);
        }

        .add-to-cart-btn {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .add-to-cart-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .no-results {
            text-align: center;
            padding: 60px 0;
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            margin-top: 20px;
        }

        .no-results i {
            font-size: 4rem;
            color: var(--medium-gray);
            margin-bottom: 20px;
        }

        .no-results p {
            font-size: 1.3rem;
            color: var(--dark-gray);
        }

        @media (max-width: 992px) {
            .container {
                width: 90%;
            }

            .vendor-card {
                flex-direction: column;
                align-items: center;
            }

            .vendor-image {
                width: 150px;
                height: 150px;
            }
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }

            .search-form {
                flex-direction: column;
                gap: 15px;
            }

            .search-input, .search-btn {
                width: 100%;
            }

            .product-actions {
                flex-direction: column;
            }

            .view-btn, .add-to-cart-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <h1><?= htmlspecialchars($vendor['shop_name']) ?></h1>
            <p class="subtitle"><?= htmlspecialchars($vendor['vendor_desc']) ?></p>
        </div>
    </div>

    <div class="container">
        <div class="vendor-card">
            <img src="<?= isset($vendor['vendor_profile']) ? 'data:image/jpeg;base64,' . base64_encode($vendor['vendor_profile']) : 'images/placeholder-shop.jpg' ?>" alt="Vendor Image" class="vendor-image">
            <div class="vendor-details">
                <div class="vendor-meta">
                    <div class="meta-item">
                        <i class="fas fa-map-marker-alt meta-icon"></i>
                        <span class="meta-label">Address:</span>
                        <span><?= htmlspecialchars($vendor['shop_address'] . ', ' . $vendor['shop_city'] . ', ' . $vendor['shop_state']) ?></span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-envelope meta-icon"></i>
                        <span class="meta-label">Email:</span>
                        <span><?= htmlspecialchars($vendor['vendor_email']) ?></span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-certificate meta-icon"></i>
                        <span class="meta-label">Tier:</span>
                        <span><?= htmlspecialchars($vendor['vendor_tier']) ?></span>
                    </div>
                </div>
                <div class="vendor-actions">
                    <a href="vendor_rating.php?id=<?= htmlspecialchars($vendor_id) ?>" class="rate-vendor-btn">
                        <i class="fas fa-star"></i> Rate Vendor
                    </a>
                </div>
            </div>
        </div>
        <?php if (empty($products)): ?>
            <div class="no-results">
                <i class="fas fa-search" style="font-size: 3rem; color: #ccc; display: block; margin-bottom: 20px;"></i>
                <p>No products found. Please try a different search term.</p>
            </div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <a href="product_details.php?product_id=<?= $product['product_id'] ?><?= !empty($query) ? '&from_search=1' : '' ?>">
                                <img src="<?= isset($product['product_profile']) ? 'data:image/jpeg;base64,' . base64_encode($product['product_profile']) : 'images/placeholder-product.jpg' ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                            </a>
                            <span class="product-category"><?= htmlspecialchars($product['product_category']) ?></span>
                        </div>
                        
                        <div class="product-info">
                            <a href="product_details.php?product_id=<?= $product['product_id'] ?><?= !empty($query) ? '&from_search=1' : '' ?>" class="product-name">
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
            
            <!-- Simple pagination for demonstration -->
            <?php if (count($products) >= 12): ?>
            <div class="pagination">
                <a href="#">&laquo;</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">&raquo;</a>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>