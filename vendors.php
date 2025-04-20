<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'nav.php';
require_once 'service/Vendors.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Listing | AgriMarket Solutions</title>
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

        .vendor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
            padding: 10px 0;
        }

        .vendor-card {
            background-color: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
        }

        .vendor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .vendor-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .vendor-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .vendor-card:hover .vendor-image img {
            transform: scale(1.05);
        }

        .vendor-tier {
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

        .vendor-info {
            padding: 15px;
        }

        .vendor-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-color);
            text-decoration: none;
            display: block;
            transition: var(--transition);
        }

        .vendor-name:hover {
            color: var(--primary-color);
        }

        .vendor-desc {
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

        .vendor-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 0.9rem;
        }

        .vendor-rating {
            display: flex;
            align-items: center;
            color: #ffa41c;
        }

        .vendor-rating i {
            margin-right: 3px;
        }

        .vendor-location {
            color: var(--dark-gray);
        }

        .vendor-actions {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        .view-btn {
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
            transition: var(--transition);
            font-weight: 500;
            font-size: 0.9rem;
            background-color: var(--primary-color);
            color: var(--white);
            flex: 1;
            border: none;
            cursor: pointer;
        }

        .view-btn:hover {
            background-color: var(--secondary-color);
        }

        .no-results {
            text-align: center;
            padding: 40px 0;
            font-size: 1.2rem;
            color: var(--dark-gray);
        }

        @media (max-width: 768px) {
            .vendor-grid {
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
            .vendor-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .vendor-image {
                height: 160px;
            }
        }
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <h1>Vendor List</h1>
            <p class="subtitle">Discover trusted local vendors</p>
        </div>
    </div>

    <div class="container">
        <div class="search-container">
            <form method="get" action="vendors.php" class="search-form">
                <input type="text" name="query" class="search-input" placeholder="Search for vendors..." 
                    value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>

        <?php if (empty($vendors)): ?>
            <div class="no-results">
                <i class="fas fa-search" style="font-size: 3rem; color: #ccc; display: block; margin-bottom: 20px;"></i>
                <p>No vendors found. Please try a different search term.</p>
            </div>
        <?php else: ?>
            <div class="vendor-grid">
                <?php foreach ($vendors as $vendor): ?>
                    <div class="vendor-card">
                        <div class="vendor-image">
                            <a href="shop.php?id=<?= $vendor['vendor_id'] ?><?= !empty($query) ? '&from_search=1' : '' ?>">
                                <img src="<?= isset($vendor['vendor_profile']) ? 'data:image/jpeg;base64,' . base64_encode($vendor['vendor_profile']) : 'path_to_placeholder.jpg' ?>" alt="<?= htmlspecialchars($vendor['shop_name']) ?>">
                            </a>
                            <span class="vendor-tier"><?= htmlspecialchars($vendor['vendor_tier']) ?></span>
                        </div>
                        
                        <div class="vendor-info">
                            <a href="shop.php?id=<?= $vendor['vendor_id'] ?><?= !empty($query) ? '&from_search=1' : '' ?>" class="vendor-name">
                                <?= htmlspecialchars($vendor['shop_name']) ?>
                            </a>
                            
                            <p class="vendor-desc"><?= htmlspecialchars($vendor['vendor_desc']) ?></p>
                            
                            <div class="vendor-meta">
                                <div class="vendor-rating">
                                    <i class="fas fa-star"></i>
                                    <span><?= isset($vendor['avg_rating']) && is_numeric($vendor['avg_rating']) ? number_format((float)$vendor['avg_rating'], 1) : 'No ratings yet' ?></span>
                                </div>
                                <div class="vendor-location">
                                    <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($vendor['shop_city']) ?>
                                </div>
                            </div>
                            
                            <div class="vendor-actions">
                                <a href="shop.php?id=<?= $vendor['vendor_id'] ?><?= !empty($query) ? '&from_search=1' : '' ?>" class="view-btn">
                                    View Shop
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>