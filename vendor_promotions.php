<?php
session_start();
require_once 'service/Vendor_Promotions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Promotions</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .container { max-width: 1200px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        input[type="text"], input[type="date"], input[type="number"] { width: 100%; padding: 6px; }
        .btn { padding: 8px 16px; background: #28a745; color: #fff; border: none; cursor: pointer; border-radius: 4px; margin-top: 10px; }
        .btn:hover { background: #218838; }
        .promo-section { margin-bottom: 40px; }
        .product-img { width: 40px; height: 40px; object-fit: cover; border-radius: 50%; }
        .rating { font-weight: bold; color: #f39c12; }
    </style>
</head>
<body>
<div class="container">

    <h2>Shop-Wide Promotion</h2>
    <form action="service/vendor_promotions.php" method="POST" class="promo-section">
        <label>Discount (in %):</label>
        <input type="text" name="vendor_promotion" placeholder="e.g. 20">

        <label>Start Date:</label>
        <input type="date" name="vendor_promo_start">

        <label>End Date:</label>
        <input type="date" name="vendor_promo_end">

        <button class="btn" type="submit" name="apply_vendor_promo">Apply Shop Promotion</button>
    </form>

    <h2>Product Promotions</h2>
    <form action="service/vendor_promotions.php" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Rating</th>
                    <th>Discount (%)</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Apply</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <?php if (!empty($product['product_profile'])): ?>
                                <img src="data:image/jpeg;base64,<?= base64_encode($product['product_profile']) ?>" class="product-img">
                            <?php else: ?>
                                <span>No image</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($product['product_name']) ?></td>
                        <td><?= htmlspecialchars($product['product_category']) ?></td>
                        <td><?= (int)$product['product_qty'] ?></td>
                        <td>$<?= number_format($product['product_price'], 2) ?></td>
                        <td class="rating"><?= is_numeric($product['rating']) ? number_format($product['rating'], 1) : 'No ratings' ?></td>
                        <td>
                            <input type="text" name="discounts[<?= $product['product_id'] ?>]" placeholder="e.g. 20">
                        </td>
                        <td>
                            <input type="date" name="start_dates[<?= $product['product_id'] ?>]">
                        </td>
                        <td>
                            <input type="date" name="end_dates[<?= $product['product_id'] ?>]">
                        </td>
                        <td>
                            <input type="checkbox" name="apply_ids[]" value="<?= $product['product_id'] ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="btn" type="submit" name="apply_product_promos">Apply Selected Product Promotions</button>
    </form>

</div>
</body>
</html>
