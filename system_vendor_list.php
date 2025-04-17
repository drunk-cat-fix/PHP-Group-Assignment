<?php
session_start();
require_once 'service/System_Vendor_List.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Vendors</title>
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
        .action-buttons {
            display: none;
            margin-top: 10px;
        }
    </style>
    <script>
        function showButtons(vendorId) {
            // Only show the buttons for the specific vendor
            document.getElementById("action-buttons_" + vendorId).style.display = "block";
        }

        function saveChanges(vendorId) {
            var tier = document.getElementById("tier_" + vendorId).value;

            // Send the updated vendor tier via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "service/System_Vendor_List.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert("✅ Vendor Tier updated successfully!");
                    document.getElementById("action-buttons_" + vendorId).style.display = "none";
                } else {
                    alert("❌ Failed to update vendor tier.");
                }
            };
            xhr.send("vendorId=" + vendorId + "&tier=" + tier);
        }

        function cancelChanges(vendorId) {
            // Hide just this vendor's action buttons
            document.getElementById("action-buttons_" + vendorId).style.display = "none";
            // Reload the page to reset any changes
            location.reload();
        }
        function deleteVendor(vendorId) {
            if (confirm("Are you sure you want to delete this vendor?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "service/System_Vendor_List.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        alert("✅ " + xhr.responseText);
                        location.reload(); // Reload page to reflect deletion
                    } else {
                        alert("❌ Failed to delete vendor.");
                    }
                };
                xhr.send("deleteVendorId=" + vendorId);
            }
        }
        function filterTable() {
            var input = document.getElementById("searchInput");
            var filter = input.value.toLowerCase();
            var table = document.querySelector("table");
            var tr = table.getElementsByTagName("tr");

            // Loop through table rows (start from 1 to skip the header)
            for (var i = 1; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td")[1]; // Vendor Name is column index 1
                if (td) {
                    var txtValue = td.textContent || td.innerText;
                    tr[i].style.display = txtValue.toLowerCase().includes(filter) ? "" : "none";
                }
            }
        }
    </script>
</head>
<body>
    <h2>Admin - Manage Vendors</h2>
    <input type="text" id="searchInput" placeholder="Search by vendor name..." onkeyup="filterTable()" style="margin-bottom: 15px; padding: 8px; width: 300px;">
    <table>
        <thead>
            <tr>
                <th>Vendor ID</th>
                <th>Vendor Name</th>
                <th>Shop Name</th>
                <th>Shop Address</th>
                <th>Shop City</th>
                <th>Shop State</th>
                <th>Description</th>
                <th>Vendor Tier</th>
                <th>Visit Count</th>
                <th>Profile</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendors as $vendor): ?>
                <tr>
                    <td><?php echo $vendor['vendor_id']; ?></td>
                    <td><?php echo $vendor['vendor_name']; ?></td>
                    <td><?php echo $vendor['shop_name']; ?></td>
                    <td><?php echo $vendor['shop_address']; ?></td>
                    <td><?php echo $vendor['shop_city']; ?></td>
                    <td><?php echo $vendor['shop_state']; ?></td>
                    <td><?php echo $vendor['vendor_desc']; ?></td>
                    <td>
                        <select id="tier_<?php echo $vendor['vendor_id']; ?>" onchange="showButtons(<?php echo $vendor['vendor_id']; ?>)">
                            <option <?php echo ($vendor['vendor_tier'] == 'Bronze') ? 'selected' : ''; ?>>Bronze</option>
                            <option <?php echo ($vendor['vendor_tier'] == 'Silver') ? 'selected' : ''; ?>>Silver</option>
                            <option <?php echo ($vendor['vendor_tier'] == 'Gold') ? 'selected' : ''; ?>>Gold</option>
                        </select>
                        <div id="action-buttons_<?php echo $vendor['vendor_id']; ?>" class="action-buttons">
                            <button onclick="saveChanges(<?php echo $vendor['vendor_id']; ?>)">Save</button>
                            <button onclick="cancelChanges(<?php echo $vendor['vendor_id']; ?>)">Cancel</button>
                        </div>
                    </td>
                    <td><?php echo $vendor['vendor_visit_count']; ?></td>
                    <td>
                        <?php
                        // Check if the profile image exists and is a valid BLOB, convert it to base64
                        if (!empty($vendor['vendor_profile'])) {
                            // Convert BLOB to base64 string
                            $imageData = base64_encode($vendor['vendor_profile']);
                            // Output the image as a data URL in the img tag
                            echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Vendor Image">';
                        } else {
                            // Show a placeholder image if no profile is available
                            echo '<img src="placeholder.jpg" alt="Vendor Image">';
                        }
                        ?>
                    </td>
                    <td><?php echo $vendor['vendor_email']; ?></td>
                    <td>
                        <button onclick="deleteVendor(<?php echo $vendor['vendor_id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>