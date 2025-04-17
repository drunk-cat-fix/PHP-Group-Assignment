<?php
require_once __DIR__ . '\..\entities\Admin.php';
require_once __DIR__ . '\..\dao\AdminDao.php';
require_once __DIR__ . '\..\Utilities\Connection.php';

if (!isset($_GET['task_id']) || empty($_GET['task_id'])) {
    die("Task ID is required.");
}

$task_id = $_GET['task_id'];
$conn = getConnection();

try {
    // Fetch task details
    $sql = "SELECT task_id, task_name, task_desc, task_start_date, task_due_date, task_done_date, order_id FROM task WHERE task_id = :task_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        die("Task not found.");
    }

    // Fetch assigned staff for the task
    $sql_staff = "SELECT staff_name 
                  FROM staff 
                  JOIN staff_task ON staff.staff_id = staff_task.staff_id 
                  WHERE staff_task.task_id = :task_id";
    $stmt_staff = $conn->prepare($sql_staff);
    $stmt_staff->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    $stmt_staff->execute();
    $assigned_staff = $stmt_staff->fetchAll(PDO::FETCH_ASSOC);

    // Create a list of staff names
    $staff_names = array_map(function($staff) {
        return htmlspecialchars($staff['staff_name']);
    }, $assigned_staff);
    $staff_names = implode(", ", $staff_names); // Comma-separated names

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
