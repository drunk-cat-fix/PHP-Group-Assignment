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
        $units = $_POST['unit'];
        $descriptions = $_POST['description'];
        $images = $_POST['image'];

        foreach ($product_names as $key => $product_name) {
            $products[] = [
                'name' => $product_name,
                'price' => $prices[$key],
                'unit' => $units[$key],
                'description' => $descriptions[$key],
                'image' => $images[$key]
            ];
        }
    }

    // Save vendor and products in session
    $_SESSION['vendors'][] = [
        'name' => $vendor_name,
        'email' => 'N/A',
        'phone' => 'N/A',
        'location' => 'N/A',
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
            <label>Product Name:</label>
            <input type="text" name="product_name[]" required><br><br>

            <label>Price:</label>
            <input type="number" name="price[]" step="0.01" required><br><br>

            <label>Unit:</label>
            <select name="unit[]" required>
                <option value="">-- Select Unit --</option>
                <option value="per tray">per tray</option>
                <option value="per kg">per kg</option>
                <option value="500 ml">500 ml</option>
                <option value="per pieces">per pieces</option>
            </select><br><br>

            <label>Description:</label>
            <textarea name="description[]" required></textarea><br><br>

            <label>Image URL:</label>
            <input type="text" name="image[]" required><br><br>
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
        <label>Product Name:</label>
        <input type="text" name="product_name[]" required><br><br>

        <label>Price:</label>
        <input type="number" name="price[]" step="0.01" required><br><br>

        <label>Unit:</label>
        <select name="unit[]" required>
            <option value="">-- Select Unit --</option>
            <option value="per tray">per tray</option>
            <option value="per kg">per kg</option>
            <option value="500 ml">500 ml</option>
            <option value="per pieces">per pieces</option>
        </select><br><br>

        <label>Description:</label>
        <textarea name="description[]" required></textarea><br><br>

        <label>Image URL:</label>
        <input type="text" name="image[]" required><br><br>
    `;

    productContainer.appendChild(newProductEntry);
};
</script>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
form {
    background-color: #fff;
    padding: 20px;
    max-width: 700px;
    margin: 20px auto;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
label {
    font-weight: bold;
}
input[type="text"], input[type="number"], textarea, select {
    width: 100%;
    padding: 8px;
    margin: 5px 0 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
}
textarea {
    resize: vertical;
}
.product-entry {
    margin-bottom: 20px;
}
.alert.success {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    margin: 20px auto;
    border-radius: 5px;
    max-width: 700px;
}
.button-container {
    text-align: center;
    margin-top: 20px;
}
.add-btn, .view-list-btn {
    display: inline-block;
    margin: 5px;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border-radius: 5px;
    text-decoration: none;
}
.add-btn:hover, .view-list-btn:hover {
    background-color: #45a049;
}
button[type="button"] {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}
button[type="button"]:hover {
    background-color: #45a049;
}
</style>
