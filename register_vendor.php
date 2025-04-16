<?php
// register_vendor.php
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vendor_name = $_POST['vendor_name'] ?? '';
    $products = [];
    
    // Add products if provided
    if (!empty($_POST['product_name']) && !empty($_POST['price'])) {
        $product_names = $_POST['product_name'];
        $prices = $_POST['price'];

        foreach ($product_names as $key => $product_name) {
            $products[] = [
                'product_name' => $product_name,
                'price' => $prices[$key]
            ];
        }
    }

    // Save vendor and products in session
    $_SESSION['vendors'][] = [
        'vendor_name' => $vendor_name,
        'products' => $products
    ];

    echo "<p class='alert success'>Vendor '$vendor_name' has been registered successfully!</p>";
}
?>

<!-- Buttons to navigate -->
<div class="button-container">
    <a href="register_vendor.php" class="add-btn">Open New Registration</a>
    <a href="list_vendors.php" class="view-list-btn">Go to Vendor List</a>
</div>

<h2>Register Vendor</h2>
<form method="POST">
    <label for="vendor_name">Vendor Name:</label>
    <input type="text" name="vendor_name" id="vendor_name" required><br><br>

    <h3>Products</h3>
    <div id="product-container">
        <div class="product-entry">
            <label for="product_name[]">Product Name:</label>
            <input type="text" name="product_name[]" required><br><br>
            <label for="price[]">Price:</label>
            <input type="number" name="price[]" step="0.01" required><br><br>
        </div>
    </div>

    <button type="button" id="add-product-btn">Add Another Product</button><br><br>
    <input type="submit" value="Register Vendor">
</form>

<script>
// JavaScript to add more product fields dynamically
document.getElementById('add-product-btn').onclick = function() {
    const productContainer = document.getElementById('product-container');
    const newProductEntry = document.createElement('div');
    newProductEntry.classList.add('product-entry');

    newProductEntry.innerHTML = `
        <label for="product_name[]">Product Name:</label>
        <input type="text" name="product_name[]" required><br><br>
        <label for="price[]">Price:</label>
        <input type="number" name="price[]" step="0.01" required><br><br>
    `;

    productContainer.appendChild(newProductEntry);
};
</script>

<style>
/* Basic Reset */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    background-color: #f4f4f4;
}

/* Button Container */
.button-container {
    margin-bottom: 20px;
}

.add-btn, .view-list-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    margin-right: 10px;
    transition: background-color 0.3s;
}

.add-btn:hover, .view-list-btn:hover {
    background-color: #45a049;
}

h2 {
    margin-top: 20px;
}

/* Form Styling */
form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 20px auto;
}

label {
    font-weight: bold;
}

input[type="text"], input[type="number"] {
    width: 100%;
    padding: 8px;
    margin: 5px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
}

button[type="button"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
    border: none;
}

button[type="button"]:hover {
    background-color: #45a049;
}

.product-entry {
    margin-bottom: 15px;
}

/* Success Alert */
.alert.success {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    margin: 20px 0;
    border-radius: 5px;
}
</style>
