<?php
use entities\Admin;
require_once __DIR__ . '/../entities/Admin.php';
require_once __DIR__ . '/../dao/AdminDao.php';
require_once __DIR__ . '/../Utilities/Connection.php';
$_SESSION['debug_log'] = [];
// Enable error logging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function debug_log($message) {
    $_SESSION['debug_log'][] = $message;
    error_log($message);
}

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
$orderId = null;

// Check if order_id is provided in URL
if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
    $orderId = $_GET['order_id'];
    
    // Get customer address and vendor info
    $orderQuery = "SELECT c.customer_address, c.customer_city, c.customer_state, v.vendor_name 
                   FROM customer_order co 
                   JOIN customer c ON co.customer_id = c.customer_id
                   JOIN order_product op ON co.order_id = op.order_id
                   JOIN product p ON op.product_id = p.product_id
                   JOIN vendor v ON p.product_vendor = v.vendor_id
                   WHERE co.order_id = :order_id
                   LIMIT 1";
    
    $stmt = $conn->prepare($orderQuery);
    $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        $vendorName = $result['vendor_name'];
        $customerAddress = $result['customer_address'] . ", " . $result['customer_city'] . ", " . $result['customer_state'];
        
        // Set pre-filled values
        $taskName = "Order Delivery #" . $orderId;
        $taskDesc = "This is a delivery task. You need to pick up a package from " . $vendorName . " and deliver to " . $customerAddress;
    } else {
        debug_log("Could not find order details for order ID: " . $orderId);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Start debug logging
        debug_log("POST request received for task creation");
        debug_log("Form data received: " . json_encode(array_keys($_POST)));
        
        // Debug staff values from hidden form inputs
        if (isset($_POST['assigned_staff'])) {
            debug_log("assigned_staff array found in POST with " . count($_POST['assigned_staff']) . " items");
            debug_log("Staff IDs: " . implode(", ", $_POST['assigned_staff']));
        } else {
            debug_log("No assigned_staff array found in POST data!");
        }
        
        $admin = new Admin();
        $admin->setTaskName($_POST['task_name']);
        $admin->setTaskDesc($_POST['task_desc']);
        $admin->setTaskStartDate($_POST['task_start_date']);
        $admin->setTaskDueDate($_POST['task_due_date']);
        
        debug_log("Task object created with name: " . $_POST['task_name']);
        
        // Check if assigned_staff exists in POST data
        $assignedStaff = isset($_POST['assigned_staff']) ? $_POST['assigned_staff'] : [];
        debug_log("Assigned staff array created with " . count($assignedStaff) . " staff members");
        
        $admin->setAssignedStaff($assignedStaff);
        
        // Check if this task is related to an order
        if (isset($_POST['order_id']) && !empty($_POST['order_id'])) {
            $orderID = $_POST['order_id'];
            debug_log("Order ID found in POST: " . $orderID);
            $admin->setOrderID($orderID);
        } else if (preg_match('/#(\d+)/', $_POST['task_name'], $matches)) {
            $orderID = $matches[1];
            debug_log("Extracted order ID from task name: " . $orderID);
            $admin->setOrderID($orderID);
        }
        
        $adminDao = new AdminDao();
        debug_log("Calling adminDao->addTask() method");
        $action = $adminDao->addTask($admin);
        
        if ($action) {
            debug_log("Task added successfully, retrieving task ID...");
    
            // Artificial 1-second delay
            sleep(1);
    
            // Retrieve the latest task ID using a custom query
            $taskIdQuery = "SELECT task_id FROM task ORDER BY task_id DESC LIMIT 1";
            $stmt = $conn->prepare($taskIdQuery);
            $stmt->execute();
            $taskId = $stmt->fetchColumn();
    
            if ($taskId) {
                debug_log("Latest task ID retrieved: " . $taskId);
            } else {
                debug_log("Failed to retrieve the latest task ID.");
                header("Location: ../admin_add_task.php?errMsg=Failed to retrieve task ID");
                exit;
            }
    
            // Insert into staff_task for each assigned staff
            $insertStmt = $conn->prepare("INSERT INTO staff_task (staff_id, task_id) VALUES (?, ?)");
    
            foreach ($assignedStaff as $staffId) {
                $insertStmt->execute([$staffId, $taskId]);
                debug_log("Assigned staff ID $staffId to task ID $taskId");
            }

            debug_log("All assigned staff linked, redirecting to task list");
            header("Location: ../admin_task_list.php");
            exit;
        } else {
            debug_log("Task addition failed, redirecting with error");
            header("Location: ../admin_add_task.php?errMsg=Failed to add task!");
            exit;
        }
    } catch (Exception $e) {
        debug_log("Exception occurred: " . $e->getMessage());
        header("Location: ../admin_add_task.php?errMsg=Exception: " . urlencode($e->getMessage()));
        exit;
    }
}
?>