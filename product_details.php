<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'service/Product_Details.php';
require_once 'nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['product_name']) ?> | AgriMarket Solutions</title>
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
            --blue: #2196F3;
            --orange: #FF9800;
            --purple: #3F51B5;
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
            padding-top: 0;
            margin-top: 0;
        }
        
        /* Ensure header has proper z-index */
        .header {
            position: relative !important;
            z-index: 9999 !important;
        }

        .navbar {
            position: relative !important;
            z-index: 9999 !important;
        }
        
        .page-header {
            background-color: var(--white);
            padding: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
            margin-top: 20px;
        }
        
        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px;
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
        
        .product-card {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
            margin-bottom: 30px;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }
        
        .product-image {
            width: 100%;
            height: auto;
            max-width: 100%;
            max-height: 50vh; /* Limits height to 50% of viewport height */
            object-fit: contain;
            border-bottom: 1px solid var(--medium-gray);
        }
        
        .product-info {
            padding: 25px;
        }
        
        .product-name {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .product-desc {
            color: var(--dark-gray);
            margin-bottom: 20px;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        .product-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
            padding: 15px;
            background-color: var(--light-gray);
            border-radius: 6px;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
        }
        
        .meta-icon {
            color: var(--primary-color);
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .meta-label {
            font-weight: 600;
            margin-right: 5px;
        }
        
        .price-section {
            margin: 25px 0;
            padding: 15px;
            background-color: rgba(76, 175, 80, 0.1);
            border-radius: 6px;
            border-left: 4px solid var(--primary-color);
        }
        
        .original-price {
            color: var(--dark-gray);
            text-decoration: line-through;
            font-size: 1.2rem;
        }
        
        .promo-price {
            color: var(--accent-color);
            font-size: 1.8rem;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .regular-price {
            color: var(--primary-color);
            font-size: 1.8rem;
            font-weight: bold;
        }
        
        .promo-tag {
            background-color: var(--accent-color);
            color: var(--white);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            vertical-align: middle;
        }
        
        .vendor-link {
            display: inline-block;
            color: var(--blue);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .vendor-link:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }
        
        .rating-stars {
            color: var(--yellow);
            font-size: 1.2rem;
            margin-top: 5px;
        }
        
        .form-section {
            margin: 25px 0;
            padding: 20px;
            background-color: var(--light-gray);
            border-radius: 8px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-group input {
            padding: 10px;
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
            font-size: 1rem;
            width: 100px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            text-align: center;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background-color: var(--blue);
            color: var(--white);
        }
        
        .btn-secondary:hover {
            background-color: #1976D2;
            transform: translateY(-2px);
        }
        
        .btn-orange {
            background-color: var(--orange);
            color: var(--white);
        }
        
        .btn-orange:hover {
            background-color: #FB8C00;
            transform: translateY(-2px);
        }
        
        .btn-purple {
            background-color: var(--purple);
            color: var(--white);
        }
        
        .btn-purple:hover {
            background-color: #303F9F;
            transform: translateY(-2px);
        }
        
        .success-message {
            padding: 15px;
            background-color: #E8F5E9;
            border-left: 4px solid var(--primary-color);
            margin: 20px 0;
            color: var(--secondary-color);
            border-radius: 4px;
        }
        
        .reviews-section {
            margin-top: 40px;
        }
        
        .section-title {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--medium-gray);
        }
        
        .review-item {
            border-bottom: 1px solid var(--medium-gray);
            padding: 20px 0;
        }
        
        .review-author {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }
        
        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }
        
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }
            
            .product-meta {
                grid-template-columns: 1fr;
            }
            
            .button-group {
                flex-direction: column;
                gap: 15px;
            }
            
            .btn {
                width: 100%;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container" style="box-shadow: none; margin-bottom: 0;">
            <h1>Product Details</h1>
            <p class="subtitle">View detailed information about this product</p>
        </div>
    </div>

    <div class="container">
        <div class="product-card">
            <img class="product-image" src="<?= isset($product['product_profile']) ? 'data:image/jpeg;base64,' . base64_encode($product['product_profile']) : 'path_to_placeholder_image.jpg' ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
            
            <div class="product-info">
                <h2 class="product-name"><?= htmlspecialchars($product['product_name']) ?></h2>
                <p class="product-desc"><?= htmlspecialchars($product['product_desc']) ?></p>
                
                <div class="product-meta">
                    <div class="meta-item">
                        <i class="fas fa-tag meta-icon"></i>
                        <span class="meta-label">Category:</span>
                        <span><?= htmlspecialchars($product['product_category']) ?></span>
                    </div>
                    
                    <div class="meta-item">
                        <i class="fas fa-cubes meta-icon"></i>
                        <span class="meta-label">Available:</span>
                        <span><?= htmlspecialchars($product['product_qty']) ?> units</span>
                    </div>
                    
                    <div class="meta-item">
                        <i class="fas fa-box meta-icon"></i>
                        <span class="meta-label">Packaging:</span>
                        <span><?= htmlspecialchars($product['product_packaging']) ?></span>
                    </div>
                    
                    <div class="meta-item">
                        <i class="fas fa-store meta-icon"></i>
                        <span class="meta-label">Vendor:</span>
                        <a href="shop.php?id=<?= $product['product_vendor'] ?>" class="vendor-link">
                            <?= htmlspecialchars($product['vendor_name']) ?>
                        </a>
                    </div>
                    
                    <div class="meta-item">
                        <i class="fas fa-star meta-icon"></i>
                        <span class="meta-label">Rating:</span>
                        <span><?= $avg_rating ?>/5</span>
                        <div class="rating-stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= floor($avg_rating)): ?>
                                    <i class="fas fa-star"></i>
                                <?php elseif ($i - 0.5 <= $avg_rating): ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php else: ?>
                                    <i class="far fa-star"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                
                <div class="price-section">
                    <?php if ($has_promotion): ?>
                        <div class="original-price">RM <?= number_format($product['product_price'], 2) ?></div>
                        <div>
                            <span class="promo-price">RM <?= number_format($promotion_price, 2) ?></span>
                            <span class="promo-tag">PROMO</span>
                        </div>
                    <?php else: ?>
                        <div class="regular-price">RM <?= number_format($product['product_price'], 2) ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Display message if product is added to cart -->
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i> <?= $_SESSION['message'] ?>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
                
                <div class="form-section">
                    <form method="POST" action="product_details.php?product_id=<?= $product_id ?>">
                        <div class="form-group">
                            <label for="quantity"><i class="fas fa-shopping-basket"></i> Quantity:</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= $product['product_qty'] ?>" required>
                        </div>
                        <input type="hidden" name="product_id" value="<?= $product_id ?>">
                        
                        <div class="button-group">
                            <button type="submit" name="add_to_cart" class="btn btn-primary">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                            
                            <?php if(isset($_SESSION['customer_id'])): ?>
                                <button type="submit" name="save_preference" class="btn btn-secondary">
                                    <i class="fas fa-heart"></i> Save as Preference
                                </button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                
                <div class="button-group">
                    <a href="product_rating.php?id=<?= $product_id ?>" class="btn btn-orange">
                        <i class="fas fa-star"></i> Write a Review
                    </a>
                    <a href="shop.php?id=<?= htmlspecialchars($product['vendor_id']) ?>" class="btn btn-purple">
                        <i class="fas fa-store"></i> Visit Shop
                    </a>
                </div>
                
                <!-- Reviews Section -->
                <div class="reviews-section">
                    <h3 class="section-title"><i class="fas fa-comments"></i> Customer Reviews</h3>
                    
                    <?php if (!empty($reviews)): ?>
                        <?php foreach ($reviews as $review): ?>
                            <div class="review-item">
                                <div class="review-author"><?= htmlspecialchars($review['customer_name']) ?></div>
                                <div class="rating-stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $review['product_rating']): ?>
                                            <i class="fas fa-star"></i>
                                        <?php else: ?>
                                            <i class="far fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <p><?= nl2br(htmlspecialchars($review['product_review'])) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No reviews yet. Be the first to review this product!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>