<?php
require_once 'service/Vendor_Product.php';
require_once 'vendor_nav.php';

if (!isset($_SESSION['vendor_id'])) {
    die("Unauthorized access! Please log in.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 20px; }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .top-bar input[type="text"] {
            padding: 8px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .top-bar button {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .top-bar button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f0f0f0;
        }

        input[type="number"] {
            width: 60px;
            padding: 4px;
        }

        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }

        .hidden {
            display: none;
        }

        .action-buttons {
            margin-top: 20px;
        }

        .action-buttons button {
            margin-right: 10px;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .save-btn {
            background-color: #28a745;
            color: white;
        }

        .cancel-btn {
            background-color: #dc3545;
            color: white;
        }

        .save-btn:hover {
            background-color: #218838;
        }

        .cancel-btn:hover {
            background-color: #c82333;
        }

        a.edit-link {
            text-decoration: none;
            color: #007bff;
        }

        a.edit-link:hover {
            text-decoration: underline;
        }

        a.review-link {
            text-decoration: none;
            color: #28a745;
        }

        a.review-link:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function enableSaveCancelButtons() {
            document.getElementById('saveCancelButtons').classList.remove('hidden');
        }

        function saveChanges() {
            if (!confirm("Are you sure you want to save these changes?")) {
                return; // User cancelled
            }

            let changedProducts = [];
            let inputs = document.querySelectorAll('input[type="number"]');

            inputs.forEach(function(input) {
                let productId = input.id.replace('qty_', '');
                let quantity = input.value;
                changedProducts.push({ id: productId, qty: quantity });
            });

            let data = JSON.stringify(changedProducts);
            console.log("Sending data:", data);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "service/Vendor_Product.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        if (xhr.responseText === "Success") {
                            alert('✅ Changes saved successfully!');
                            document.getElementById('saveCancelButtons').classList.add('hidden');
                        } else {
                            alert('⚠️ Error: ' + xhr.responseText);
                        }
                    } else {
                        alert('❌ Request failed. Status: ' + xhr.status);
                    }
                }
            };
            xhr.onerror = function () {
                alert('❌ Network error!');
            };
            xhr.send(data);
        }

        function cancelChanges() {
            location.reload();
        }

        function filterTable() {
            let filter = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                let name = row.cells[1].textContent.toLowerCase();
                row.style.display = name.includes(filter) ? '' : 'none';
            });
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Manage Products</h2>

    <div class="top-bar">
        <button onclick="location.href='vendor_add_product.php'">+ Add Product</button>
        <input type="text" id="searchInput" placeholder="Search product name..." onkeyup="filterTable()">
    </div>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Packaging</th>
            <th>Price</th>
            <th>Rating</th>
            <th>Image</th>
            <th>Visits</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['product_id'] ?></td>
                <td><a class="edit-link" href="vendor_edit_product.php?id=<?= $product['product_id'] ?>"><?= htmlspecialchars($product['product_name']) ?></a></td>
                <td><?= htmlspecialchars($product['product_desc']) ?></td>
                <td><?= htmlspecialchars($product['product_category']) ?></td>
                <td>
                    <input type="number" id="qty_<?= $product['product_id'] ?>" value="<?= $product['product_qty'] ?>" onchange="enableSaveCancelButtons()">
                </td>
                <td><?= htmlspecialchars($product['product_packaging']) ?></td>
                <td>$<?= number_format($product['product_price'], 2) ?></td>
                <td>
                    <a class="review-link" href="vendor_view_review.php?product_id=<?= $product['product_id'] ?>">
                        <?= is_numeric($product['avg_rating']) ? number_format($product['avg_rating'], 1) : 'No ratings' ?>
                    </a>
                </td>
                <td>
                    <?php if (!empty($product['product_profile'])): ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($product['product_profile']) ?>" alt="Product Image">
                    <?php else: ?>
                        <img src="placeholder.jpg" alt="No Image">
                    <?php endif; ?>
                </td>
                <td><?= $product['product_visit_count'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="action-buttons hidden" id="saveCancelButtons">
        <button class="save-btn" onclick="saveChanges()">💾 Save</button>
        <button class="cancel-btn" onclick="cancelChanges()">✖ Cancel</button>
    </div>
</div>
</body>
</html>
