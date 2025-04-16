<?php
// edit_vendor.php
session_start();

if (!isset($_GET['vendor_id'])) {
    echo "Vendor not found.";
    exit;
}

$vendor_id = $_GET['vendor_id'];

if (!isset($_SESSION['vendors'][$vendor_id])) {
    echo "Vendor not found.";
    exit;
}

$vendor = $_SESSION['vendors'][$vendor_id];

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vendor_name = $_POST['vendor_name'] ?? '';
    $products = [];

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

    $_SESSION['vendors'][$vendor_id]['name'] = $vendor_name;
    $_SESSION['vendors'][$vendor_id]['products'] = $products;

    echo "<p class='alert success'>Vendor '$vendor_name' has been updated successfully!</p>";
}

// Handle product deletion
if (isset($_GET['delete_product_id'])) {
    $delete_product_id = $_GET['delete_product_id'];

    if (isset($vendor['products'][$delete_product_id])) {
        unset($vendor['products'][$delete_product_id]);
        $_SESSION['vendors'][$vendor_id]['products'] = array_values($vendor['products']);
        echo "<p class='alert success'>Product has been deleted successfully.</p>";
    }
}
?>

<h2>Edit Vendor</h2>
<form method="POST">
    <label for="vendor_name">Vendor Name:</label>
    <input type="text" name="vendor_name" id="vendor_name" value="<?php echo htmlspecialchars($vendor['name']); ?>" required><br><br>

    <h3>Products</h3>
    <div id="product-container">
        <?php foreach ($vendor['products'] as $product_id => $product): ?>
            <div class="product-entry">
                <label>Product Name:</label>
                <input type="text" name="product_name[]" value="<?= htmlspecialchars($product['name']) ?>" required><br><br>

                <label>Price:</label>
                <input type="number" name="price[]" step="0.01" value="<?= htmlspecialchars($product['price']) ?>" required><br><br>

                <label>Unit:</label>
                <select name="unit[]" required>
                    <option value="">-- Select Unit --</option>
                    <?php
                    $units = ['per tray', 'per kg', '500 ml', 'per pieces'];
                    foreach ($units as $unit) {
                        $selected = ($product['unit'] === $unit) ? 'selected' : '';
                        echo "<option value=\"$unit\" $selected>$unit</option>";
                    }
                    ?>
                </select><br><br>

                <label>Description:</label>
                <textarea name="description[]" required><?= htmlspecialchars($product['description']) ?></textarea><br><br>

                <label>Image URL:</label>
                <input type="text" name="image[]" value="<?= htmlspecialchars($product['image']) ?>" required><br><br>

                <a href="?vendor_id=<?= $vendor_id ?>&delete_product_id=<?= $product_id ?>" class="delete-product-btn" onclick="return confirmDelete()">Delete Product</a>
            </div>
        <?php endforeach; ?>
    </div>

    <button type="button" id="add-product-btn">Add Another Product</button><br><br>
    <input type="submit" value="Update Vendor">
</form>

<div class="button-container">
    <a href="list_vendors.php" class="back-btn">Back to Vendor List</a>
</div>

<script>
document.getElementById('add-product-btn').onclick = function() {
    const container = document.getElementById('product-container');
    const entry = document.createElement('div');
    entry.classList.add('product-entry');
    entry.innerHTML = `
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
    container.appendChild(entry);
};

function confirmDelete() {
    return confirm('Are you sure you want to delete this product?');
}
</script>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}
form {
    background-color: #fff;
    padding: 20px;
    max-width: 700px;
    margin: 20px auto;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
button[type="button"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
button[type="button"]:hover {
    background-color: #45a049;
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
.back-btn {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
}
.back-btn:hover {
    background-color: #0056b3;
}
.delete-product-btn {
    display: inline-block;
    padding: 8px 15px;
    background-color: #f44336;
    color: white;
    border-radius: 5px;
    text-decoration: none;
}
.delete-product-btn:hover {
    background-color: #da190b;
}
</style>
