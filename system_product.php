<?php
session_start();
require_once 'service/System_Product.php';

// Handle search when the form is submitted
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$filteredProducts = array_filter($products, function ($product) use ($searchTerm) {
    return stripos($product['product_name'], $searchTerm) !== false;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Products</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            cursor: pointer;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        .hidden {
            display: none;
        }
        #searchBar {
            margin-bottom: 10px;
            padding: 8px;
            width: 300px;
        }
    </style>
    <script>
        let sortOrder = {}; // Store sorting state per column

        function sortTable(columnIndex) {
            const table = document.getElementById("productTable");
            const tbody = table.getElementsByTagName("tbody")[0];
            const rows = Array.from(tbody.getElementsByTagName("tr"));

            // Toggle sorting order
            sortOrder[columnIndex] = !sortOrder[columnIndex];
            const ascending = sortOrder[columnIndex];

            const sortedRows = rows.sort((rowA, rowB) => {
                let cellA = rowA.cells[columnIndex].innerText.trim();
                let cellB = rowB.cells[columnIndex].innerText.trim();

                // Remove currency symbols or other non-numeric characters for price columns
                cellA = cellA.replace(/[^0-9.-]+/g, '');
                cellB = cellB.replace(/[^0-9.-]+/g, '');

                const a = isNaN(cellA) ? cellA.toLowerCase() : parseFloat(cellA);
                const b = isNaN(cellB) ? cellB.toLowerCase() : parseFloat(cellB);

                return ascending ? (a > b ? 1 : -1) : (a < b ? 1 : -1);
            });

            // Reattach rows
            tbody.innerHTML = "";
            sortedRows.forEach(row => tbody.appendChild(row));
        }

        function handleSearchKey(event) {
            if (event.key === 'Enter') {
                const searchValue = document.getElementById('searchBar').value;
                window.location.href = '?search=' + encodeURIComponent(searchValue);
            }
        }
    </script>
</head>
<body>
    <h2>Admin - Manage Products</h2>
    
    <!-- Search Bar -->
    <input type="text" id="searchBar" placeholder="Search by product name..." 
           value="<?php echo htmlspecialchars($searchTerm); ?>" 
           onkeypress="handleSearchKey(event)">

    <table id="productTable">
        <thead>
            <tr>
                <th onclick="sortTable(0)">Product ID</th>
                <th onclick="sortTable(1)">Product Name</th>
                <th>Description</th>
                <th onclick="sortTable(3)">Vendor Name</th>
                <th onclick="sortTable(4)">Category</th>
                <th onclick="sortTable(5)">Quantity</th>
                <th onclick="sortTable(6)">Packaging</th>
                <th onclick="sortTable(7)">Price</th>
                <th onclick="sortTable(8)">Rating</th>
                <th onclick="sortTable(9)">Visit Count</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($filteredProducts as $product): ?>
                <tr>
                    <td><?php echo $product['product_id']; ?></td>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_desc']); ?></td>
                    <td><?php echo htmlspecialchars($product['vendor_name']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_category']); ?></td>
                    <td><?php echo $product['product_qty']; ?></td>
                    <td><?php echo htmlspecialchars($product['product_packaging']); ?></td>
                    <td>$<?php echo number_format($product['product_price'], 2); ?></td>
                    <td>
                        <?php
                        $rating = isset($product['avg_rating']) ? round($product['avg_rating']) : 0;
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $rating) {
                                echo '<span style="color: gold;">&#9733;</span>'; // Filled star
                            } else {
                                echo '<span style="color: #ccc;">&#9734;</span>'; // Empty star
                            }
                        }
                        ?>
                    </td>
                    <td><?php echo $product['product_visit_count']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
