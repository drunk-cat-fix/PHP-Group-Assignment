<?php
// File: service/Vendor_Shop_Review.php
require_once __DIR__ . '/../Utilities/Connection.php';

// Get the vendor ID from the session
$vendor_id = $_SESSION['vendor_id'];

$conn = getConnection();

// Fetch shop name
$shop_sql = "SELECT shop_name FROM vendor WHERE vendor_id = :vendor_id";
$shop_stmt = $conn->prepare($shop_sql);
$shop_stmt->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
$shop_stmt->execute();
$shop_result = $shop_stmt->fetch(PDO::FETCH_ASSOC);
$shop_name = $shop_result ? $shop_result['shop_name'] : 'Your Shop';

// Fetch reviews for the vendor's shop
$sql = "
    SELECT vr.vendor_review_id, vr.vendor_rating, vr.vendor_review, c.customer_name 
    FROM vendor_review vr
    JOIN customer c ON vr.customer_id = c.customer_id
    JOIN vendor v ON vr.vendor_id = v.vendor_id
    WHERE v.vendor_id = :vendor_id
    ORDER BY vr.vendor_review_id DESC
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate statistics
$total_reviews = count($reviews);
$average_rating = 0;

if ($total_reviews > 0) {
    $sum_ratings = 0;
    foreach ($reviews as $review) {
        $sum_ratings += $review['vendor_rating'];
    }
    
    $average_rating = $sum_ratings / $total_reviews;
} else {
    $average_rating = 0;
}
?>