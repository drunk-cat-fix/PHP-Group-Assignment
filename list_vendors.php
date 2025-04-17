<?php
// list_vendors.php
session_start();

// Check if any vendors are stored in the session
if (!isset($_SESSION['vendors']) || count($_SESSION['vendors']) === 0) {
    echo "<p>No vendors registered yet.</p>";
} else {
    echo "<h2>List of Registered Vendors</h2>";

    // Check if delete action is requested
    if (isset($_GET['delete_vendor_id'])) {
        $delete_vendor_id = $_GET['delete_vendor_id'];

        // Remove vendor from the session
        if (isset($_SESSION['vendors'][$delete_vendor_id])) {
            unset($_SESSION['vendors'][$delete_vendor_id]);
            $_SESSION['vendors'] = array_values($_SESSION['vendors']); // Reindex the array
            echo "<p class='alert success'>Vendor has been deleted successfully.</p>";
        }
    }

    // Add Vendor Button
    echo "<a href='register_vendor.php' class='add-btn'>Add Vendor</a>";

    // Display the list of vendors
    echo "<div class='vendor-list'>";
    foreach ($_SESSION['vendors'] as $vendor_id => $vendor) {
        echo "<div class='vendor-card'>";
        echo "<h3>" . htmlspecialchars($vendor['vendor_name']) . "</h3>";

        // Edit Vendor Button
        echo "<a href='edit_vendor.php?vendor_id=$vendor_id' class='edit-btn'>Edit Vendor</a>";
        
        echo "<h4>Products:</h4>";
        if (count($vendor['products']) > 0) {
            echo "<table class='product-table'>
                    <tr><th>Product Name</th><th>Price</th></tr>";
            foreach ($vendor['products'] as $product) {
                echo "<tr><td>" . htmlspecialchars($product['product_name']) . "</td>
                      <td>$" . htmlspecialchars($product['price']) . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No products available for this vendor.</p>";
        }

        // Delete vendor link
        echo "<a href='?delete_vendor_id=$vendor_id' class='delete-btn' onclick='return confirmDelete()'>Delete Vendor</a>";
        echo "</div>"; // Close vendor card
    }
    echo "</div>"; // Close vendor list
}
?>

<!-- Modal for deletion confirmation -->
<div id="delete-modal" class="modal">
    <div class="modal-content">
        <h4>Are you sure you want to delete this vendor?</h4>
        <button id="confirm-delete" class="confirm-btn">Yes, Delete</button>
        <button id="cancel-delete" class="cancel-btn">Cancel</button>
    </div>
</div>

<script>
// JavaScript for modal confirmation
function confirmDelete() {
    var modal = document.getElementById('delete-modal');
    modal.style.display = 'block';
    
    // Handle cancel and confirm actions
    document.getElementById('cancel-delete').onclick = function() {
        modal.style.display = 'none';
        return false; // Prevent deletion
    };
    
    document.getElementById('confirm-delete').onclick = function() {
        modal.style.display = 'none';
        return true; // Allow deletion
    };
    return false; // Prevent the default confirmation
}

// Close modal when clicked outside
window.onclick = function(event) {
    var modal = document.getElementById('delete-modal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
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

/* Vendor List */
.vendor-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
}

.vendor-card {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 300px;
    margin: 10px;
    text-align: center;
}

.vendor-card h3 {
    margin: 0;
    color: #333;
}

.product-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.product-table th, .product-table td {
    padding: 8px;
    border: 1px solid #ddd;
    text-align: left;
}

.product-table th {
    background-color: #f7f7f7;
}

.delete-btn {
    display: inline-block;
    margin-top: 15px;
    padding: 8px 15px;
    background-color: #ff4c4c;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.delete-btn:hover {
    background-color: #e60000;
}

.add-btn {
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s;
}

.add-btn:hover {
    background-color: #45a049;
}

.edit-btn {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 15px;
    background-color: #ffa500;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.edit-btn:hover {
    background-color: #ff8c00;
}

.alert.success {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    margin: 20px 0;
    border-radius: 5px;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    overflow: auto;
    padding-top: 60px;
}

.modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    border-radius: 8px;
    width: 300px;
    text-align: center;
}

.confirm-btn, .cancel-btn {
    padding: 10px 15px;
    margin: 10px;
    border-radius: 5px;
    cursor: pointer;
}

.confirm-btn {
    background-color: #4CAF50;
    color: white;
}

.cancel-btn {
    background-color: #f44336;
    color: white;
}

.confirm-btn:hover {
    background-color: #45a049;
}

.cancel-btn:hover {
    background-color: #da190b;
}
</style>
