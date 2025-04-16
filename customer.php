<?php
// customer.php
session_start();

// Check if there are any vendors in the session
if (!isset($_SESSION['vendors']) || count($_SESSION['vendors']) === 0) {
    echo "<p>No vendors available yet.</p>";
} else {
    echo "<div class='vendors-container'>";
    foreach ($_SESSION['vendors'] as $vendor_id => $vendor) {
        echo "<div class='vendor-card'>";
        echo "<h3 class='vendor-name'>" . htmlspecialchars($vendor['vendor_name']) . "</h3>";
        echo "<div class='products-list'>";
        
        if (count($vendor['products']) > 0) {
            echo "<ul class='product-list'>";
            foreach ($vendor['products'] as $product_id => $product) {
                echo "<li class='product-item'>
                        <span class='product-name'>" . htmlspecialchars($product['product_name']) . "</span>
                        <span class='product-price'>Price: $" . htmlspecialchars($product['price']) . "</span>
                        <a href='add_to_cart.php?vendor_id=$vendor_id&product_id=$product_id' class='add-to-cart-btn'>Add to Cart</a>
                      </li>";
            }
            echo "</ul>";
        } else {
            echo "<p class='no-products'>No products available for this vendor.</p>";
        }

        echo "</div>"; // Close products-list
        echo "</div>"; // Close vendor-card
    }
    echo "</div>"; // Close vendors-container
}
?>

<!-- Back Button -->
<div class="button-container">
    <a href="index.php" class="back-btn">Back to Home</a>
</div>

<style>
/* Basic Reset */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    background-color: #fafafa;
    color: #333;
}

/* Container for all vendors */
.vendors-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 20px;
}

/* Vendor Card Styling */
.vendor-card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin: 20px;
    padding: 15px;
    width: 300px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.vendor-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

.vendor-name {
    font-size: 22px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.products-list {
    margin-top: 15px;
}

/* Product List */
.product-list {
    list-style: none;
    padding: 0;
}

.product-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    padding: 8px;
    background-color: #f9f9f9;
    border-radius: 5px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease;
}

.product-item:hover {
    background-color: #e9f7e7;
}

.product-name {
    font-size: 16px;
    font-weight: 600;
}

.product-price {
    font-size: 16px;
    color: #4caf50;
}

.add-to-cart-btn {
    padding: 8px 14px;
    background-color: #4caf50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
    transition: background-color 0.3s;
}

.add-to-cart-btn:hover {
    background-color: #388e3c;
}

/* No Products Message */
.no-products {
    font-size: 14px;
    color: #888;
    text-align: center;
    padding: 10px;
}

/* Back Button */
.button-container {
    margin-top: 20px;
    text-align: center;
}

.back-btn {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 16px;
    transition: background-color 0.3s;
}

.back-btn:hover {
    background-color: #0056b3;
}
</style>
