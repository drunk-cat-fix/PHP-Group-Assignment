<?php
use entities\Admin;
require_once __DIR__ . '/../entities/Admin.php';
require_once __DIR__ . '/../dao/AdminDao.php';
require_once __DIR__ . '/../Utilities/Connection.php';

// Enable error logging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$staffList = [];
$conn = getConnection();
$staffQuery = "SELECT staff_id, staff_name FROM staff";
$stmt = $conn->prepare($staffQuery);
$stmt->execute();
$staffList = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Default values
$taskName = "";
$taskDesc = "";
$taskStartDate = date('Y-m-d'); // Today
$taskDueDate = date('Y-m-d', strtotime('+14 days')); // 14 days from today

// Check if order_id is provided in URL
if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
    $orderId = $_GET['order_id'];
    
    // Get vendor name based on order_id
    $vendorQuery = "SELECT v.vendor_name 
                    FROM vendor v
                    JOIN product p ON v.vendor_id = p.product_vendor
                    JOIN order_product op ON p.product_id = op.product_id
                    WHERE op.order_id = :order_id
                    LIMIT 1";
    
    $stmt = $conn->prepare($vendorQuery);
    $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $vendorName = $result && isset($result['vendor_name']) ? $result['vendor_name'] : "unknown vendor";
    
    // Set pre-filled values
    $taskName = "Order Delivery #" . $orderId;
    $taskDesc = "This is a delivery task. You need to pick up a package from " . $vendorName . " and deliver to address."; //change address to customer address, need to read database.
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {        
        $admin = new Admin();
        $admin->setTaskName($_POST['task_name']);
        $admin->setTaskDesc($_POST['task_desc']);
        $admin->setTaskStartDate($_POST['task_start_date']);
        $admin->setTaskDueDate($_POST['task_due_date']);
        
        // Check if assigned_staff exists in POST data
        $assignedStaff = isset($_POST['assigned_staff']) ? $_POST['assigned_staff'] : [];
        $admin->setAssignedStaff($assignedStaff);
        
        $adminDao = new AdminDao();
        $action = $adminDao->addTask($admin);
        
        if ($action) {
            header("Location: ../admin_task_list.php");
            exit;
        } else {
            header("Location: ../admin_add_task.php?errMsg=Failed to add task!");
            exit;
        }
    } catch (Exception $e) {
        error_log("Exception in Admin_Add_Task.php: " . $e->getMessage());
        header("Location: ../admin_add_task.php?errMsg=Exception: " . urlencode($e->getMessage()));
        exit;
    }
}
?>