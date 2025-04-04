<?php
session_start();
$vendor_id = 3;
require_once 'service/Vendor_Service.php';
/*
if (!isset($_SESSION['vendor_id'])) {
    die("Unauthorized access! Please log in.");
}
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor - Manage Services</title>
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
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <h2>Vendor - Manage Services</h2>
    <button onclick="location.href='vendor_add_service.php'">Add Service</button>
    <table>
        <thead>
            <tr>
                <th>Service ID</th>
                <th>Service Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price</th>
                <th>Profile</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($services as $service): ?>
                <tr>
                    <td><?php echo $service['service_id']; ?></td>
                    <td>
                        <a href="vendor_edit_service.php?id=<?php echo $service['service_id']; ?>" 
                           style="text-decoration: none; color: inherit;"
                           onmouseover="this.style.textDecoration='underline';"
                           onmouseout="this.style.textDecoration='none';">
                            <?php echo htmlspecialchars($service['service_name']); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($service['service_desc']); ?></td>
                    <td><?php echo htmlspecialchars($service['service_category']); ?></td>
                    <td>$<?php echo number_format($service['service_price'], 2); ?></td>
                    <td>
                        <?php
                        if (!empty($service['service_profile'])) {
                            $imageData = base64_encode($service['service_profile']);
                            echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="service Image">';
                        } else {
                            echo '<img src="placeholder.jpg" alt="service Image">';
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
