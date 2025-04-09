<?php
require_once __DIR__ . '\..\entities\Staff.php';
require_once __DIR__ . '\..\dao\StaffDao.php';
require_once __DIR__ . '\..\Utilities\Connection.php';

// Check if this is an AJAX request with JSON data
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if ($contentType === "application/json") {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true); // Decode JSON input
    
    $staffDao = new StaffDao();
    $success = true;
    $message = "Changes saved successfully.";
    
    // Handle task completion updates
    if (isset($data['task_updates']) && !empty($data['task_updates'])) {
        $taskUpdates = $data['task_updates']; // Array of task IDs marked as done
        $taskResult = $staffDao->updateTaskStatus($taskUpdates);
        
        if (!$taskResult) {
            $success = false;
            $message = "Failed to update task status.";
        }
    }
    
    // Handle progress updates
    if (isset($data['progress_updates']) && !empty($data['progress_updates'])) {
        $progressUpdates = $data['progress_updates']; // Array of objects with order_id and progress values
        $progressResult = $staffDao->updateDeliveryProgress($progressUpdates);
        
        if (!$progressResult) {
            $success = false;
            $message = "Failed to update delivery progress.";
        }
    }
    
    echo json_encode(["success" => $success, "message" => $message]);
    exit();
}

// Regular page load logic
$staff_id = $_POST['staff_id'] ?? $_SESSION['staff_id'] ?? null;
if (!$staff_id) {
    header("location: ../login.php?errMsg=Unauthorized access!");
    exit();
}

$conn = getConnection();
$sql = "SELECT t.task_id, t.task_name, t.task_desc, t.task_start_date, t.task_due_date, 
        t.task_done_date, t.order_id, s.staff_name, co.deliver_percent
        FROM task t
        JOIN staff_task st ON t.task_id = st.task_id
        JOIN staff s ON st.staff_id = s.staff_id
        LEFT JOIN customer_order co ON t.order_id = co.order_id
        WHERE s.staff_id = :staff_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>