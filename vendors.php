<?php
session_start();
require_once 'nav.php';
require_once 'service/Vendors.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Listing</title>
    <style>
        .vendor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .vendor-card {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
        }
        .vendor-card img {
            max-width: 100%;
            height: auto;
            cursor: pointer;
        }
        .vendor-card h3 {
            margin: 10px 0;
            cursor: pointer;
        }
        .vendor-card p {
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
<h1>Vendors</h1>
<form method="get" action="vendors.php" style="padding: 20px;">
    <input type="text" name="query" placeholder="Search vendor..." value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
    <button type="submit">Go</button>
</form>

<div class="vendor-grid">
    <?php foreach ($vendors as $vendor): ?>
        <div class="vendor-card">
            <a href="shop.php?id=<?= $vendor['vendor_id'] ?>">
                <img src="<?= isset($vendor['vendor_profile']) ? 'data:image/jpeg;base64,' . base64_encode($vendor['vendor_profile']) : 'path_to_placeholder.jpg' ?>">
            </a>
            <a href="shop.php?id=<?= $vendor['vendor_id'] ?>">
                <h3><?= htmlspecialchars($vendor['shop_name']) ?></h3>
            </a>
            <p><?= htmlspecialchars($vendor['vendor_desc']) ?></p>
            <p>Tier: <?= htmlspecialchars($vendor['vendor_tier']) ?></p>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
