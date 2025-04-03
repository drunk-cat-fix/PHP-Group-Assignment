<?php
use entities\Admin;
require_once __DIR__ . '/../entities\Admin.php';
require_once __DIR__ . '/../dao\AdminDao.php';
require_once __DIR__ . "/../Utilities/Connection.php";


$task_id = isset($_GET['task_id']) ? intval($_GET['task_id']) : (isset($_POST['task_id']) ? intval($_POST['task_id']) : 0);
if ($task_id <= 0) {
    die("Invalid Task ID.");
}

$conn = getConnection();
$sql = "SELECT task_id, task_name, task_desc, task_start_date, task_due_date, task_done_date, order_id FROM task WHERE task_id = :task_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':task_id', $task_id);
$stmt->execute();
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    die("Task not found.");
}

$staffSql = "SELECT staff_id, staff_name FROM staff";
$staffStmt = $conn->prepare($staffSql);
$staffStmt->execute();
$staffList = $staffStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_POST) {
    $admin = new Admin();
    $admin->setTaskID($task_id);
    $admin->setTaskName($_POST['task_name']);
    $admin->setTaskDesc($_POST['task_desc']);
    $admin->setTaskStartDate($_POST['task_start_date']);
    $admin->setTaskDueDate($_POST['task_due_date']);
    $admin->setAssignedStaff($_POST['assigned_staff']);
    $adminDao = new AdminDao();
    $action = $adminDao->editTask($admin);
    if ($action) {
        header("location: ../admin_task_list.php");
    } else {
        header("location: ../admin_edit_task.php?task_id={$task_id}&errMsg=Failed to update task!");
    }
}
?>