<?php
session_start();
require_once 'service/System_Vendor_List.php';
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit();
}if (isset($_SESSION['admin_id'])) {
require_once 'admin_nav.php';
} else if (isset($_SESSION['staff_id'])) {
require_once 'staff_nav.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Vendors</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        input[type="text"] {
            padding: 10px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        td {
            font-size: 14px;
        }

        td img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .action-buttons {
            display: none;
            margin-top: 10px;
        }

        .action-buttons button {
            padding: 6px 12px;
            margin: 0 5px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .action-buttons button:hover {
            background-color: #ddd;
        }

        button.delete-btn {
            background-color: #f44336;
            color: white;
        }

        button.save-btn {
            background-color: #4CAF50;
            color: white;
        }

        button.cancel-btn {
            background-color: #888;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        @media (max-width: 768px) {
            th, td {
                padding: 10px;
            }

            input[type="text"] {
                max-width: 100%;
            }
        }
    </style>
    <script>
        function showButtons(vendorId) {
            document.getElementById("action-buttons_" + vendorId).style.display = "block";
        }

        function saveChanges(vendorId) {
            var tier = document.getElementById("tier_" + vendorId).value;
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
            document.getElementById("action-buttons_" + vendorId).style.display = "none";
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
                        location.reload();
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

            for (var i = 1; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td")[1];
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
    <input type="text" id="searchInput" placeholder="Search by vendor name..." onkeyup="filterTable()">
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
                            <button class="save-btn" onclick="saveChanges(<?php echo $vendor['vendor_id']; ?>)">Save</button>
                            <button class="cancel-btn" onclick="cancelChanges(<?php echo $vendor['vendor_id']; ?>)">Cancel</button>
                        </div>
                    </td>
                    <td><?php echo $vendor['vendor_visit_count']; ?></td>
                    <td>
                        <?php
                        if (!empty($vendor['vendor_profile'])) {
                            $imageData = base64_encode($vendor['vendor_profile']);
                            echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Vendor Image">';
                        } else {
                            echo '<img src="placeholder.jpg" alt="Vendor Image">';
                        }
                        ?>
                    </td>
                    <td><?php echo $vendor['vendor_email']; ?></td>
                    <td>
                        <button class="delete-btn" onclick="deleteVendor(<?php echo $vendor['vendor_id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
