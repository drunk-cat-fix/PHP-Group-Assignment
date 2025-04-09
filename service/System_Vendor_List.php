<?php
require_once __DIR__ . '\..\entities\Staff.php';
require_once __DIR__ . '\..\dao\StaffDao.php';
require_once __DIR__ . '\..\Utilities\Connection.php';

// Fetch the vendor data from the database
$conn = getConnection();
$sql = "SELECT vendor_id, vendor_name, shop_name, shop_address, shop_city, shop_state, vendor_desc, vendor_tier, vendor_visit_count, vendor_profile, vendor_email FROM vendor";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bindColumn('vendor_profile', $vendor['vendor_profile'], PDO::PARAM_LOB);
$vendors = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if this is an AJAX request to update vendor tier
if (isset($_POST['vendorId']) && isset($_POST['tier'])) {
    $staff = new StaffDao();
    $vendorId = $_POST['vendorId'];
    $tier = $_POST['tier'];
    
    // Call the DAO function to update the vendor tier
    $updated = $staff->updateVendorTier($vendorId, $tier);
    
    // Return a success or failure message
    if ($updated) {
        echo "Vendor Tier updated successfully!";
    } else {
        echo "Failed to update Vendor Tier.";
    }
    exit; // Stop execution here for AJAX requests
}

?>