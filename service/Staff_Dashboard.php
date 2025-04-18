<?php
require_once __DIR__ . '/../entities/Staff.php';
require_once __DIR__ . '/../dao/StaffDao.php';
require_once __DIR__ . '/../Utilities/Connection.php';

// Use session staff_id if set, otherwise use default for testing
$_SESSION['staff_id'] = $_SESSION['staff_id'] ?? NULL;

// Handle AJAX requests
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if ($contentType === "application/json") {
    $data = json_decode(file_get_contents("php://input"), true);
    $response = ['success' => false, 'message' => 'Invalid request'];
    
    // For backward compatibility - check for old format
    if (isset($data['task_updates']) || isset($data['progress_updates'])) {
        $taskUpdates = $data['task_updates'] ?? [];
        $progressUpdates = $data['progress_updates'] ?? [];
        
        $success = true;
        
        // Process task updates
        if (!empty($taskUpdates)) {
            if (!updateTaskStatus($taskUpdates)) {
                $success = false;
                $response = ['success' => false, 'message' => 'Error updating task status'];
            }
        }
        
        // Process progress updates
        if ($success && !empty($progressUpdates)) {
            if (!updateDeliveryProgress($progressUpdates)) {
                $success = false;
                $response = ['success' => false, 'message' => 'Error updating delivery progress'];
            }
        }
        
        if ($success) {
            $response = ['success' => true, 'message' => 'Updates completed successfully'];
        }
    }
    // Check for new format with 'action' parameter
    else if (isset($data['action'])) {
        switch ($data['action']) {
            case 'updateTaskStatus':
                if (isset($data['taskIds']) && is_array($data['taskIds'])) {
                    if (updateTaskStatus($data['taskIds'])) {
                        $response = ['success' => true, 'message' => 'Tasks updated successfully'];
                    } else {
                        $response = ['success' => false, 'message' => 'Error updating tasks'];
                    }
                }
                break;
                
            case 'updateDeliveryProgress':
                if (isset($data['progressUpdates']) && is_array($data['progressUpdates'])) {
                    if (updateDeliveryProgress($data['progressUpdates'])) {
                        $response = ['success' => true, 'message' => 'Delivery progress updated successfully'];
                    } else {
                        $response = ['success' => false, 'message' => 'Error updating delivery progress'];
                    }
                }
                break;
                
            default:
                $response = ['success' => false, 'message' => 'Unknown action'];
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Regular page load logic
$staff_id = $_POST['staff_id'] ?? $_SESSION['staff_id'] ?? null;
if (!$staff_id) {
    header("location: login.php");
    exit();
}
$conn = getConnection();
// First, get the tasks assigned to the logged-in staff
$sql = "SELECT DISTINCT t.task_id, t.task_name, t.task_desc, t.task_start_date, t.task_due_date, 
        t.task_done_date, t.order_id, co.deliver_percent
        FROM task t
        JOIN staff_task st ON t.task_id = st.task_id
        LEFT JOIN customer_order co ON t.order_id = co.order_id
        WHERE st.staff_id = :staff_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Now get all staff assigned to these tasks
$taskIds = array_column($tasks, 'task_id');
if (!empty($taskIds)) {
    // Get all staff assigned to these tasks
    $staffSql = "SELECT st.task_id, s.staff_name 
                FROM staff_task st
                JOIN staff s ON st.staff_id = s.staff_id
                WHERE st.task_id IN (" . implode(',', array_fill(0, count($taskIds), '?')) . ")";
    
    $staffStmt = $conn->prepare($staffSql);
    
    // Bind all task IDs as parameters
    foreach ($taskIds as $index => $taskId) {
        $staffStmt->bindValue($index + 1, $taskId, PDO::PARAM_INT);
    }
    
    $staffStmt->execute();
    $staffAssignments = $staffStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Group staff names by task_id
    $taskStaffMap = [];
    foreach ($staffAssignments as $assignment) {
        $task_id = $assignment['task_id'];
        $staff_name = $assignment['staff_name'];
        if (!isset($taskStaffMap[$task_id])) {
            $taskStaffMap[$task_id] = [];
        }
        $taskStaffMap[$task_id][] = $staff_name;
    }
    
    // Create a new tasks array with staff names added
    $updatedTasks = [];
    foreach ($tasks as $task) {
        $tid = $task['task_id'];
        $task['assigned_staff'] = isset($taskStaffMap[$tid]) ? implode(', ', $taskStaffMap[$tid]) : 'Unassigned';
        $updatedTasks[] = $task;
    }
    
    // Replace the original tasks array with the updated one
    $tasks = $updatedTasks;
}

/**
 * Update task status to completed
 * 
 * @param array $taskIds Array of task IDs to mark as completed
 * @return bool Success or failure
 */
function updateTaskStatus($taskIds) {
    $conn = getConnection();
    $conn->beginTransaction();
    try {
        $today = date('Y-m-d');
        foreach ($taskIds as $taskId) {
            // Check if this task is linked to an order and verify progress is 100%
            $sql = "SELECT t.order_id, IFNULL(co.deliver_percent, 0) as deliver_percent
                    FROM task t
                    LEFT JOIN customer_order co ON t.order_id = co.order_id
                    WHERE t.task_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$taskId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Skip tasks with orders that don't have 100% progress
            if ($result['order_id'] && $result['deliver_percent'] < 100) {
                continue;
            }
            
            // Update task_done_date in the task table
            $sql = "UPDATE task SET task_done_date = ? WHERE task_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$today, $taskId]);
            if ($result['order_id']) {
                // Update deliver_date and deliver_status in customer_order table
                $sql = "UPDATE customer_order SET deliver_date = ?, deliver_status = 'Delivered', isInProgress = FALSE, isDelivered = TRUE, isRead = FALSE WHERE order_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$today, $result['order_id']]);
            }
        }
        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollBack();
        return false;
    }
}

/**
 * Update delivery progress percentages for orders
 *  
 * @param array $progressUpdates Array of objects with order_id and progress values
 * @return bool Success or failure
 */
function updateDeliveryProgress($progressUpdates) {
    $conn = getConnection();
    $conn->beginTransaction();
    try {
        $today = date('Y-m-d');
        
        foreach ($progressUpdates as $update) {
            $orderId = $update['order_id'];
            $progress = $update['progress'];
            
            if ($progress >= 100) {
                // If progress is 100%, update order as delivered
                $sql = "UPDATE customer_order SET 
                        deliver_percent = ?, 
                        deliver_date = ?,
                        deliver_status = 'Delivered',
                        isInProgress = FALSE, 
                        isDelivered = TRUE,
                        isRead = FALSE
                        WHERE order_id = ?";
                        
                $stmt = $conn->prepare($sql);
                $stmt->execute([$progress, $today, $orderId]);
                
                // Also mark the associated task as complete
                $taskSql = "UPDATE task SET task_done_date = ? 
                           WHERE order_id = ? AND task_done_date IS NULL";
                $taskStmt = $conn->prepare($taskSql);
                $taskStmt->execute([$today, $orderId]);
            } else {
                // For non-100% progress, just update the progress value
                $sql = "UPDATE customer_order SET 
                        deliver_percent = ?,
                        isInProgress = TRUE,
                        isDelivered = FALSE
                        WHERE order_id = ?";
                        
                $stmt = $conn->prepare($sql);
                $stmt->execute([$progress, $orderId]);
            }
        }
        
        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Error in updateDeliveryProgress: " . $e->getMessage());
        return false;
    }
}
?>