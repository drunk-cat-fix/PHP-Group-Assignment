<?php
require_once __DIR__ . '\..\Utilities\Connection.php';

$conn = getConnection();

// Check if the form has been submitted to add a product to the cart
if (isset($_POST['add_to_cart'])) {
    // Get product ID and quantity from the form
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if the cart already exists in the session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        // If product exists in cart, update the quantity
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        // If product does not exist in the cart, add it
        $_SESSION['cart'][$product_id] = $quantity;
    }

    // Optionally, set a message to confirm the product was added
    $_SESSION['message'] = "Product added to cart!";
}

// Get the product ID from the URL
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : 0;

$visit_sql = "UPDATE product SET product_visit_count = product_visit_count + 1 WHERE product_id = :product_id";
$visit_stmt = $conn->prepare($visit_sql);
$visit_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$visit_stmt->execute();

if (isset($_GET['from_search']) && $_GET['from_search'] == 1 && isset($_SESSION['searched_ids'])) {
    if (in_array($product_id, $_SESSION['searched_ids'])) {
        $search_sql = "UPDATE product SET product_search_count = product_search_count + 1 WHERE product_id = :product_id";
        $search_stmt = $conn->prepare($search_sql);
        $search_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $search_stmt->execute();
    }
}

// Fetch the product details from the database
$sql = "SELECT 
            p.product_name,
            p.product_desc,
            p.product_category,
            p.product_qty,
            p.product_packaging,
            p.product_price,
            p.product_promotion,
            p.product_vendor,
            v.vendor_name,
            v.vendor_id,
            p.product_profile
        FROM product p
        JOIN vendor v ON v.vendor_id = p.product_vendor
        WHERE p.product_id = :product_id";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$stmt->execute();

// Fetch the product details
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Calculate promotion price if applicable
$has_promotion = false;
$promotion_price = null;
if (!empty($product['product_promotion']) && $product['product_promotion'] < 1) {
    $has_promotion = true;
    $promotion_price = $product['product_price'] * $product['product_promotion'];
}

// Fetch the rating for the product
$rating_sql = "SELECT AVG(product_rating) as avg_rating FROM product_review WHERE product_id = :product_id";
$rating_stmt = $conn->prepare($rating_sql);
$rating_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$rating_stmt->execute();
$rating = $rating_stmt->fetch(PDO::FETCH_ASSOC);

// Calculate the average rating (if there are reviews)
$avg_rating = $rating['avg_rating'] ? number_format($rating['avg_rating'], 2) : 'No ratings yet';

// Fetch reviews with customer name
$review_sql = "SELECT pr.product_review, pr.product_rating, c.customer_name 
               FROM product_review pr
               JOIN customer c ON c.customer_id = pr.customer_id
               WHERE pr.product_id = :product_id
               ORDER BY pr.review_id DESC";

$review_stmt = $conn->prepare($review_sql);
$review_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$review_stmt->execute();
$reviews = $review_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle saving product as preference
if (isset($_POST['save_preference']) && isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];
    $product_id = $_POST['product_id'];
    
    // Check if preference already exists
    $check_sql = "SELECT * FROM customer_preference 
                  WHERE customer_id = :customer_id AND product_id = :product_id";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
    $check_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $check_stmt->execute();
    
    if ($check_stmt->rowCount() == 0) {
        // Insert new preference if it doesn't exist
        $insert_sql = "INSERT INTO customer_preference (customer_id, product_id) 
                       VALUES (:customer_id, :product_id)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $insert_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        
        try {
            $insert_stmt->execute();
            $_SESSION['message'] = "Product saved to your preferences!";
        } catch (PDOException $e) {
            $_SESSION['message'] = "Error saving preference: " . $e->getMessage();
        }
    } else {
        // Preference already exists
        $_SESSION['message'] = "This product is already in your preferences!";
    }
}
unset($_SESSION['searched_ids']);
?>