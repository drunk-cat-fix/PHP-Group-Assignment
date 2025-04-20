<?php
session_start();
if (!isset($_SESSION['vendor_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'service/Vendor_Shop_Review.php';
require_once 'vendor_nav.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shop Reviews</title>
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
        .stats-container {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            flex: 1;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            text-align: center;
        }
        .stat-number {
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        .stat-label {
            color: #6c757d;
            font-size: 14px;
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
        .rating {
            display: flex;
            align-items: center;
        }
        .star {
            color: #ffc107;
            margin-right: 3px;
        }
        .empty-star {
            color: #e0e0e0;
            margin-right: 3px;
        }
        .filter-controls {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        select, input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        p {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
    <h2>
        Customer Reviews for <?php echo htmlspecialchars($shop_name ?: "Your Shop"); ?>
    </h2>
    
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-number"><?php echo number_format($average_rating, 1); ?></div>
            <div class="stat-label">Average Rating</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_reviews; ?></div>
            <div class="stat-label">Total Reviews</div>
        </div>
    </div>
    
    <div class="filter-controls">
        <div>
            <label for="rating-filter">Filter by Rating:</label>
            <select id="rating-filter" onchange="filterReviews()">
                <option value="all">All Ratings</option>
                <option value="5">5 Stars</option>
                <option value="4">4 Stars</option>
                <option value="3">3 Stars</option>
                <option value="2">2 Stars</option>
                <option value="1">1 Star</option>
            </select>
        </div>
        <div>
            <input type="text" id="search-input" placeholder="Search reviews..." onkeyup="searchReviews()">
        </div>
    </div>
    
    <?php if (count($reviews) === 0): ?>
        <p>No reviews found for your shop.</p>
    <?php else: ?>
        <table id="reviews-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Rating</th>
                    <th>Review</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                    <tr data-rating="<?php echo htmlspecialchars($review['vendor_rating']); ?>">
                        <td><?php echo htmlspecialchars($review['customer_name']); ?></td>
                        <td>
                            <div class="rating">
                                <?php 
                                $rating = (int)$review['vendor_rating'];
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        echo '<span class="star">★</span>';
                                    } else {
                                        echo '<span class="empty-star">☆</span>';
                                    }
                                }
                                ?>
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars($review['vendor_review']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <script>
        function filterReviews() {
            const rating = document.getElementById('rating-filter').value;
            const rows = document.querySelectorAll('#reviews-table tbody tr');
            
            rows.forEach(row => {
                if (rating === 'all' || row.getAttribute('data-rating') === rating) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        function searchReviews() {
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const rows = document.querySelectorAll('#reviews-table tbody tr');
            
            rows.forEach(row => {
                const reviewText = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const customerName = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                
                if (reviewText.includes(searchTerm) || customerName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>