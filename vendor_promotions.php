<?php
require_once 'service/Vendor_Promotions.php';
require_once 'vendor_nav.php';
if (!isset($_SESSION['vendor_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Promotions</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        form {
            margin-bottom: 40px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: 500;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .btn {
            margin-top: 15px;
            background-color: #007bff;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }

        th {
            background-color: #f9f9f9;
            font-weight: bold;
            color: #555;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }

        .rating {
            font-weight: bold;
            color: #f39c12;
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 10px;
            }

            td {
                border: none;
                padding: 8px 0;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                display: block;
                margin-bottom: 4px;
                color: #333;
            }

            th {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="container">

    <h2>Shop-Wide Promotion</h2>
    <form action="service/vendor_promotions.php" method="POST" class="promo-section">
        <label for="vendor_promotion">Discount (in %):</label>
        <input type="text" name="vendor_promotion" placeholder="e.g. 20">

        <label for="vendor_promo_start">Start Date:</label>
        <input type="date" name="vendor_promo_start">

        <label for="vendor_promo_end">End Date:</label>
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
                    <td data-label="Image">
                        <?php if (!empty($product['product_profile'])): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($product['product_profile']) ?>" class="product-img">
                        <?php else: ?>
                            <span>No image</span>
                        <?php endif; ?>
                    </td>
                    <td data-label="Product"><?= htmlspecialchars($product['product_name']) ?></td>
                    <td data-label="Category"><?= htmlspecialchars($product['product_category']) ?></td>
                    <td data-label="Qty"><?= (int)$product['product_qty'] ?></td>
                    <td data-label="Price">$<?= number_format($product['product_price'], 2) ?></td>
                    <td data-label="Rating" class="rating">
                        <?= is_numeric($product['rating']) ? number_format($product['rating'], 1) : 'No ratings' ?>
                    </td>
                    <td data-label="Discount">
                        <input type="text" name="discounts[<?= $product['product_id'] ?>]" placeholder="e.g. 20">
                    </td>
                    <td data-label="Start Date">
                        <input type="date" name="start_dates[<?= $product['product_id'] ?>]">
                    </td>
                    <td data-label="End Date">
                        <input type="date" name="end_dates[<?= $product['product_id'] ?>]">
                    </td>
                    <td data-label="Apply">
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
