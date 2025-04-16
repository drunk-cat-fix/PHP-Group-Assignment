<?php
session_start();
require_once 'service/Customer_Sort_Display.php';
$sort_by = $_GET['sort_by'] ?? 'vendor_tier';
$products = getAllProducts($sort_by);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Sorting</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        select, button {
            padding: 8px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
<h2>Product Sorting</h2>

<!-- Sort by Dropdown -->
<form method="GET">
    <label for="sort_by">Sort by:</label>
    <select name="sort_by" id="sort_by">
        <option value="vendor_tier" <?= $sort_by == 'vendor_tier' ? 'selected' : ''; ?>>Vendor Tier</option>
        <option value="promotion" <?= $sort_by == 'product_promotion' ? 'selected' : ''; ?>>Product Promotion</option>
        <option value="page" <?= $sort_by == 'product_visit_count' ? 'selected' : ''; ?>>Product Visit Count</option>
        <option value="visit_count" <?= $sort_by == 'vendor_visit_count' ? 'selected' : ''; ?>>Vendor Visit Count</option>
    </select>
    <button type="submit">Sort</button>
</form>

<!-- Product Table -->
<table>
    <thead>
    <tr>
        <th>Product Name</th>
        <th>Vendor Tier</th>
        <th>Promotion</th>
        <th>Page</th>
        <th>Visit Count</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['product_name']) ?></td>
                <td><?= htmlspecialchars($product['vendor_tier']) ?></td>
                <td><?= htmlspecialchars($product['product_promotion']) ?></td>
                <td><?= htmlspecialchars($product['product_visit_count']) ?></td>
                <td><?= htmlspecialchars($product['vendor_visit_count']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No products found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>
