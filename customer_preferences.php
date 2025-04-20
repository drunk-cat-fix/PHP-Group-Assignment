<?php
session_start();
require_once 'nav.php';
require_once __DIR__. '/Utilities/Connection.php';
require_once __DIR__. '/service/Customer_Order_Operations.php';
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
// Fetch favorite products
$products = getAllPreferencesByCusId($_SESSION['customer_id']);

// Calculate total favorite products
$totalFavorites = 0;
$productsArray = [];
while ($row = $products->fetch(PDO::FETCH_ASSOC)) {
    $productsArray[] = $row;
    $totalFavorites++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favourite Products | AgriMarket Solutions</title>
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
            z-index: 1; /* Ensure this is below the navigation */
            margin-top: 20px; /* Add spacing below the navbar */
            z-index: 1;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
        }

        .container:first-of-type {
            position: relative;
            z-index: 1;
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
        
        .summary-card {
            background-color: var(--light-gray);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            transition: var(--transition);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .summary-title {
            color: var(--dark-gray);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .summary-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .summary-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: var(--shadow);
            border-radius: 8px;
            overflow: hidden;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--medium-gray);
        }
        
        th {
            background-color: var(--primary-color);
            color: var(--white);
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        tbody tr {
            transition: var(--transition);
        }
        
        tbody tr:nth-child(even) {
            background-color: rgba(76, 175, 80, 0.05);
        }
        
        tbody tr:hover {
            background-color: rgba(76, 175, 80, 0.1);
        }
        
        .product-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }
        
        .product-link:hover {
            color: var(--secondary-color);
        }
        
        .product-link i {
            margin-right: 5px;
        }
        
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid var(--medium-gray);
        }
        
        .price {
            font-weight: bold;
            color: var(--accent-color);
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 0;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            color: var(--medium-gray);
            margin-bottom: 20px;
        }
        
        .empty-state-message {
            font-size: 1.2rem;
            color: var(--dark-gray);
            margin-bottom: 20px;
        }
        
        .shop-now-btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--white);
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            transition: var(--transition);
        }
        
        .shop-now-btn:hover {
            background-color: var(--secondary-color);
        }
        
        @media (max-width: 992px) {
            .container {
                width: 90%;
            }
        }
        
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            th, td {
                padding: 12px 10px;
            }
            
            .product-image {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container" style="box-shadow: none; margin-bottom: 0;">
            <h1>Favourite Products</h1>
            <p class="subtitle">View and manage your favorite products</p>
        </div>
    </div>

    <div class="container">
        <?php if (!empty($productsArray)): ?>
            <div class="summary-card">
                <div class="summary-icon"><i class="fas fa-heart"></i></div>
                <div class="summary-title">Total Favorites</div>
                <div class="summary-value"><?= $totalFavorites ?></div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Product Description</th>
                        <th>Product Picture</th>
                        <th>Product Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productsArray as $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['product_id']) ?></td>
                            <td>
                                <a href="product_details.php?product_id=<?= urlencode($product['product_id']) ?>" class="product-link">
                                    <i class="fas fa-leaf"></i> <?= htmlspecialchars($product['product_name']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($product['product_desc']) ?></td>
                            <td>
                                <?php if (!empty($product['product_profile'])): ?>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($product['product_profile']) ?>" class="product-image" alt="Product Picture">
                                <?php else: ?>
                                    <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td class="price">RM <?= number_format($product['product_price'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <div class="empty-state-message">
                    You haven't added any products to your favorites yet.
                </div>
                <a href="products.php" class="shop-now-btn">
                    <i class="fas fa-store"></i> Start Shopping
                </a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>