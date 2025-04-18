<?php
session_start();
require_once 'service/System_Service.php';
if ($_SESSION['admin_id'] != NULL) {
require_once 'admin_nav.php';
} else if ($_SESSION['staff_id'] != NULL) {
require_once 'staff_nav.php';
}
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$filteredServices = array_filter($services, function ($service) use ($searchTerm) {
    return stripos($service['service_name'], $searchTerm) !== false;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Services</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
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
            cursor: pointer;
        }
        th:hover {
            background-color: #e6e6e6;
        }
        td {
            padding: 12px;
            vertical-align: top;
        }
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
        #searchBar {
            padding: 8px;
            width: 300px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }
        h2 {
            color: #333;
        }
        .placeholder-image {
            width: 50px;
            height: 50px;
            background-color: #ccc;
            border-radius: 50%;
        }
    </style>
    <script>
        let sortOrder = {}; // Store sorting state per column

        function sortTable(columnIndex) {
            const table = document.getElementById("serviceTable");
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
    <h2>Admin - Manage Services</h2>
    
    <!-- Search Bar -->
    <input type="text" id="searchBar" placeholder="Search by service name..." 
           value="<?php echo htmlspecialchars($searchTerm); ?>" 
           onkeypress="handleSearchKey(event)">

    <table id="serviceTable">
        <thead>
            <tr>
                <th onclick="sortTable(0)">Service ID</th>
                <th onclick="sortTable(1)">Service Name</th>
                <th>Description</th>
                <th onclick="sortTable(3)">Vendor Name</th>
                <th onclick="sortTable(4)">Category</th>
                <th onclick="sortTable(5)">Price</th>
                <th>Profile</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($filteredServices as $service): ?>
                <tr>
                    <td><?php echo $service['service_id']; ?></td>
                    <td><?php echo htmlspecialchars($service['service_name']); ?></td>
                    <td><?php echo htmlspecialchars($service['service_desc']); ?></td>
                    <td><?php echo htmlspecialchars($service['vendor_name']); ?></td>
                    <td><?php echo htmlspecialchars($service['service_category']); ?></td>
                    <td>$<?php echo number_format($service['service_price'], 2); ?></td>
                    <td>
                        <?php
                        if (!empty($service['service_profile'])) {
                            $imageData = base64_encode($service['service_profile']);
                            echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Service Image">';
                        } else {
                            echo '<div class="placeholder-image"></div>';
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
