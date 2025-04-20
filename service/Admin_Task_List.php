<?php
session_start();
use entities\Admin;
require_once __DIR__ . '/../entities/Admin.php';
require_once __DIR__ . '/../dao/AdminDao.php';
require_once __DIR__ . '/../Utilities/Connection.php';

$conn = getConnection();

// Fetch tasks
$sql = "SELECT task_id, task_name, task_desc, task_start_date, task_due_date, task_done_date, order_id FROM task ORDER BY task_id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch staff assignments
$staffSql = "SELECT t.task_id, s.staff_name
             FROM staff_task st
             JOIN staff s ON st.staff_id = s.staff_id
             JOIN task t ON st.task_id = t.task_id";
$staffStmt = $conn->prepare($staffSql);
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

// Create a new array for tasks with staff assignments
$tasksWithStaff = [];
foreach ($tasks as $task) {
    $tid = $task['task_id'];
    $task['assigned_staffs'] = isset($taskStaffMap[$tid]) ? implode(', ', $taskStaffMap[$tid]) : 'Unassigned';
    $tasksWithStaff[] = $task;
}

// Replace the original array with the new one
$tasks = $tasksWithStaff;
?>