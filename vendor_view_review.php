<?php
session_start();
if (!isset($_SESSION['vendor_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'service/Vendor_View_Review.php';
require_once 'vendor_nav.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Reviews</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 40px;
            color: #333;
        }

        h2 {
            margin-bottom: 20px;
            color: #2c3e50;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: 500;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9f5ff;
        }

        p {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
    <h2>
        Reviews for Product:
        <?php echo htmlspecialchars($product_name ?: "Unknown"); ?>
    </h2>

    <?php if (count($reviews) === 0): ?>
        <p>No reviews found for this product.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Rating</th>
                    <th>Review</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($review['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($review['product_rating']); ?></td>
                        <td><?php echo htmlspecialchars($review['product_review']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
