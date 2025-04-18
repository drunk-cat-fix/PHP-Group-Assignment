<?php
session_start();
$vendor_id = 3;
require_once 'service/Vendor_Service.php';
require_once 'vendor_nav.php';
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
        body {
            margin: 0;
            padding: 20px;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }

        h2 {
            margin-bottom: 20px;
            color: #212529;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .add-service-btn {
            padding: 10px 16px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.2s ease;
        }

        .add-service-btn:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        th, td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background-color: #f1f3f5;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        a.service-link {
            color: #007bff;
            text-decoration: none;
        }

        a.service-link:hover {
            text-decoration: underline;
        }

        img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>
</head>
<body>

    <div class="top-bar">
        <h2>Vendor - Manage Services</h2>
        <button class="add-service-btn" onclick="location.href='vendor_add_service.php'">Add Service</button>
    </div>

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
            <?php foreach ($services as $service): ?>
                <tr>
                    <td><?php echo $service['service_id']; ?></td>
                    <td>
                        <a class="service-link" href="vendor_edit_service.php?id=<?php echo $service['service_id']; ?>">
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
                            echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Service Image">';
                        } else {
                            echo '<img src="placeholder.jpg" alt="No Image">';
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
