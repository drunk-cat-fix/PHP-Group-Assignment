<?php
session_start();
require_once 'service/System_Product.php';

if ($_SESSION['admin_id'] != NULL) {
require_once 'admin_nav.php';
} else if ($_SESSION['staff_id'] != NULL) {
require_once 'staff_nav.php';
}

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 20px; }

        #searchBar {
            padding: 8px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            word-wrap: break-word;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            cursor: pointer;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .star {
            color: gold;
        }

        .star-grey {
            color: #ccc;
        }
    </style>
    <script>
        let sortOrder = {};

        function sortTable(columnIndex) {
            const table = document.getElementById("productTable");
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));

            sortOrder[columnIndex] = !sortOrder[columnIndex];
            const ascending = sortOrder[columnIndex];

            const sortedRows = rows.sort((rowA, rowB) => {
                let cellA = rowA.cells[columnIndex].innerText.trim();
                let cellB = rowB.cells[columnIndex].innerText.trim();

                cellA = cellA.replace(/[^0-9.-]+/g, '');
                cellB = cellB.replace(/[^0-9.-]+/g, '');

                const a = isNaN(cellA) ? cellA.toLowerCase() : parseFloat(cellA);
                const b = isNaN(cellB) ? cellB.toLowerCase() : parseFloat(cellB);

                return ascending ? (a > b ? 1 : -1) : (a < b ? 1 : -1);
            });

            tbody.innerHTML = "";
            sortedRows.forEach(row => tbody.appendChild(row));
        }

        function filterTable() {
            const filter = document.getElementById('searchBar').value.toLowerCase();
            document.querySelectorAll('#productTable tbody tr').forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                row.style.display = name.includes(filter) ? '' : 'none';
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Admin - Manage Products</h2>
        <input type="text" id="searchBar" placeholder="Search by product name..." onkeyup="filterTable()" value="<?= htmlspecialchars($searchTerm) ?>">

        <table id="productTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">ID</th>
                    <th onclick="sortTable(1)">Name</th>
                    <th>Description</th>
                    <th onclick="sortTable(3)">Category</th>
                    <th onclick="sortTable(4)">Quantity</th>
                    <th>Packaging</th>
                    <th onclick="sortTable(6)">Price</th>
                    <th onclick="sortTable(7)">Rating</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['product_id'] ?></td>
                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                    <td><?= htmlspecialchars($product['product_desc']) ?></td>
                    <td><?= htmlspecialchars($product['product_category']) ?></td>
                    <td><?= $product['product_qty'] ?></td>
                    <td><?= htmlspecialchars($product['product_packaging']) ?></td>
                    <td>$<?= number_format($product['product_price'], 2) ?></td>
                    <td>
                        <?php if (is_numeric($product['avg_rating'])): ?>
                            <?= number_format($product['avg_rating'], 1) ?>
                        <?php else: ?>
                            No ratings
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
