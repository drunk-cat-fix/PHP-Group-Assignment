<?php
session_start();
require_once __DIR__. '/nav.php';
require_once __DIR__. '/Utilities/Connection.php';
require_once __DIR__. '/service/Customer_Order_Operations.php';
$products = getAllPreferencesByCusId($_SESSION['customer_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Favourite Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .price {
            font-weight: bold;
            color: #e74c3c;
        }
    </style>
</head>
<body>
<h1>Favourite List</h1>

<?php if (empty($products)): ?>
    <p style="color: red">There is no product information . </p>
<?php else: ?>
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
        <?php while ($product=$products->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
              <td><?= htmlspecialchars($product['product_id']) ?></td>
              <td><?= htmlspecialchars($product['product_name']) ?></td>
              <td><?= htmlspecialchars($product['product_desc']) ?></td>
              <td>
                <?php if (!empty($product['product_profile'])): ?>
                  <img src="data:image/jpeg;base64,<?= base64_encode($product['product_profile']) ?>" width="150" height="150" class="mb-3 rounded" alt="Product Picture">
                <?php else: ?>
                  <span class="text-muted">No image</span>
                <?php endif; ?>
              </td>
              <td class="price">$<?= number_format($product['product_price'], 2) ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>
</body>
</html>
