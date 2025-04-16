<?php
// edit_vendor.php
session_start();

// Check if vendor ID is passed in the query string
if (!isset($_GET['vendor_id'])) {
    echo "Vendor not found.";
    exit;
}

$vendor_id = $_GET['vendor_id'];

// Check if vendor exists in the session
if (!isset($_SESSION['vendors'][$vendor_id])) {
    echo "Vendor not found.";
    exit;
}

$vendor = $_SESSION['vendors'][$vendor_id];

// Handle form submission for editing vendor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vendor_name = $_POST['vendor_name'] ?? '';
    $products = [];

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

    // Update vendor information
    $_SESSION['vendors'][$vendor_id] = [
        'vendor_name' => $vendor_name,
        'products' => $products
    ];

    echo "<p class='alert success'>Vendor '$vendor_name' has been updated successfully!</p>";
}

// Handle product deletion
if (isset($_GET['delete_product_id'])) {
    $delete_product_id = $_GET['delete_product_id'];

    // Remove the product from the vendor's products list
    if (isset($vendor['products'][$delete_product_id])) {
        unset($vendor['products'][$delete_product_id]);
        // Reindex the array after deletion
        $_SESSION['vendors'][$vendor_id]['products'] = array_values($vendor['products']);
        echo "<p class='alert success'>Product has been deleted successfully.</p>";
    }
}

?>

<h2>Edit Vendor</h2>
<form method="POST">
    <label for="vendor_name">Vendor Name:</label>
    <input type="text" name="vendor_name" id="vendor_name" value="<?php echo htmlspecialchars($vendor['vendor_name']); ?>" required><br><br>

    <h3>Products</h3>
    <div id="product-container">
        <?php
        foreach ($vendor['products'] as $product_id => $product) {
            echo "<div class='product-entry'>
                    <label for='product_name[]'>Product Name:</label>
                    <input type='text' name='product_name[]' value='" . htmlspecialchars($product['product_name']) . "' required><br><br>
                    <label for='price[]'>Price:</label>
                    <input type='number' name='price[]' step='0.01' value='" . htmlspecialchars($product['price']) . "' required><br><br>
                    <a href='?vendor_id=$vendor_id&delete_product_id=$product_id' class='delete-product-btn' onclick='return confirmDelete()'>Delete Product</a>
                </div>";
        }
        ?>
    </div>

    <button type="button" id="add-product-btn">Add Another Product</button><br><br>
    <input type="submit" value="Update Vendor">
</form>

<!-- Back Button -->
<div class="button-container">
    <a href="list_vendors.php" class="back-btn">Back to Vendor List</a>
</div>

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

// Confirm deletion of product
function confirmDelete() {
    return confirm('Are you sure you want to delete this product?');
}
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

/* Back Button */
.button-container {
    margin-top: 20px;
}

.back-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s;
}

.back-btn:hover {
    background-color: #0056b3;
}

/* Delete Product Button */
.delete-product-btn {
    display: inline-block;
    padding: 8px 15px;
    background-color: #f44336;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
    margin-top: 10px;
    transition: background-color 0.3s;
}

.delete-product-btn:hover {
    background-color: #da190b;
}
</style>
