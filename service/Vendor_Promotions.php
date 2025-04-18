<?php
require_once __DIR__ . '/../Utilities/Connection.php';
$conn = getConnection();
$vendor_id = $_SESSION['vendor_id'] ?? null;

if (!$vendor_id) {
    die("Unauthorized access.");
}

// 1. Apply Shop-Wide Promotion
if (isset($_POST['apply_vendor_promo'])) {
    $promo = $_POST['vendor_promotion'];
    $start = $_POST['vendor_promo_start'];
    $end = $_POST['vendor_promo_end'];

    if (!empty($promo) && !empty($start) && !empty($end)) {
        $multiplier = parseDiscountToMultiplier($promo); // Only convert to multiplier now
        $stmt = $conn->prepare("UPDATE vendor SET vendor_promotion = ?, promo_start_date = ?, promo_end_date = ? WHERE vendor_id = ?");
        $stmt->execute([$multiplier, $start, $end, $vendor_id]);
    }

    $_SESSION['message'] = "Shop promotion applied.";
    header("Location: ../vendor_promotions.php");
    exit();
}

// 2. Apply Product Promotions
if (isset($_POST['apply_product_promos']) && isset($_POST['apply_ids'])) {
    $discounts = $_POST['discounts'];
    $starts = $_POST['start_dates'];
    $ends = $_POST['end_dates'];
    $productIds = $_POST['apply_ids'];

    foreach ($productIds as $productId) {
        $discountInput = $discounts[$productId] ?? '';
        $start = $starts[$productId] ?? '';
        $end = $ends[$productId] ?? '';

        if ($discountInput !== '' && $start && $end) {
            $multiplier = parseDiscountToMultiplier($discountInput);
            $update = $conn->prepare("UPDATE product SET product_promotion = ?, promo_start_date = ?, promo_end_date = ? WHERE product_id = ? AND product_vendor = ?");
            $update->execute([$multiplier, $start, $end, $productId, $vendor_id]);
        }
    }

    $_SESSION['message'] = "Product promotions applied.";
    header("Location: ../vendor_promotions.php");
    exit();
}

// 3. Read products with rating calculation
$productStmt = $conn->prepare("SELECT product_id, product_name, product_category, product_qty, product_price, product_profile FROM product WHERE product_vendor = ?");
$productStmt->execute([$vendor_id]);
$products = $productStmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($products as &$product) {
    $product_id = $product['product_id'];

    $ratingSumStmt = $conn->prepare("SELECT SUM(product_rating) FROM product_review WHERE product_id = ?");
    $ratingSumStmt->execute([$product_id]);
    $sum = $ratingSumStmt->fetchColumn();

    $ratingCountStmt = $conn->prepare("SELECT COUNT(*) FROM product_review WHERE product_id = ?");
    $ratingCountStmt->execute([$product_id]);
    $count = $ratingCountStmt->fetchColumn();

    $product['rating'] = ($count > 0) ? round($sum / $count, 2) : 'No ratings';
}

// ✅ Helper: Convert % string (e.g., "20%" or "20") to multiplier (e.g., 0.8)
function parseDiscountToMultiplier($input) {
    $input = trim($input);
    
    // Remove % if exists
    $percentValue = str_ends_with($input, '%') 
        ? floatval(str_replace('%', '', $input)) 
        : floatval($input);

    // Clamp between 0-100
    if ($percentValue < 0) $percentValue = 0;
    if ($percentValue > 100) $percentValue = 100;

    // Convert to multiplier
    $multiplier = (100 - $percentValue) / 100;

    return round($multiplier, 2); // example: 20 -> 0.8
}
?>