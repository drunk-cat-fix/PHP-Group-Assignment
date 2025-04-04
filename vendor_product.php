<?php
session_start();
$vendor_id = 1;
require_once 'service/Vendor_Product.php';
/*
if (!isset($_SESSION['vendor_id'])) {
    die("Unauthorized access! Please log in.");
}
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor - Manage Products</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        .hidden {
            display: none;
        }
    </style>
    <script>
        function enableSaveCancelButtons() {
            document.getElementById('saveCancelButtons').classList.remove('hidden');
        }

        function saveChanges() {
            // Collect all changed quantities
            let changedProducts = [];
            let inputs = document.querySelectorAll('input[type="number"]');

            inputs.forEach(function(input) {
                let productId = input.id.replace('qty_', '');
                let quantity = input.value;
        
                changedProducts.push({
                    id: productId,
                    qty: quantity
                });
            });

            let data = JSON.stringify(changedProducts);
            console.log("Sending data:", data);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "service/Vendor_Product.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    console.log("Status:", xhr.status);
                    console.log("Response:", xhr.responseText);
            
                    if (xhr.status == 200) {
                        if (xhr.responseText === "Success") {
                            alert('✅ Changes saved successfully!');
                            document.getElementById('saveCancelButtons').classList.add('hidden');
                        } else {
                            console.error("Server returned:", xhr.responseText);
                            alert('⚠️ Server responded but indicated an error: ' + xhr.responseText);
                        }
                    } else {
                        alert('❌ Error saving changes! Status: ' + xhr.status);
                    }
                }
            };
            xhr.onerror = function() {
                console.error("Network error occurred");
                alert('❌ Network error occurred!');
            };
            xhr.send(data);
        }

        function cancelChanges() {
            location.reload();
        }
    </script>
</head>
<body>
    <h2>Vendor - Manage Products</h2>
    <button onclick="location.href='vendor_add_product.php'">Add Product</button>
    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Packaging</th>
                <th>Price</th>
                <th>Rating</th>
                <th>Profile</th>
                <th>Visit Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['product_id']; ?></td>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_desc']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_category']); ?></td>
                    <td>
                        <input type="number" id="qty_<?php echo $product['product_id']; ?>" 
                               value="<?php echo $product['product_qty']; ?>" 
                               onchange="enableSaveCancelButtons()">
                    </td>
                    <td><?php echo htmlspecialchars($product['product_packaging']); ?></td>
                    <td>$<?php echo number_format($product['product_price'], 2); ?></td>
                    <td><?php echo $product['product_rating']; ?></td>
                    <td>
                        <?php
                        if (!empty($product['product_profile'])) {
                            $imageData = base64_encode($product['product_profile']);
                            echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Product Image">';
                        } else {
                            echo '<img src="placeholder.jpg" alt="Product Image">';
                        }
                        ?>
                    </td>
                    <td><?php echo $product['product_visit_count']; ?></td>
                    <td>
                        <button onclick="location.href='vendor_edit_product.php?id=<?php echo $product['product_id']; ?>'">Edit</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div id="saveCancelButtons" class="hidden">
        <button onclick="saveChanges()">Save Changes</button>
        <button onclick="cancelChanges()">Cancel</button>
    </div>
</body>
</html>
