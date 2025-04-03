<?php
require_once "Utilities/Connection.php";

if (!isset($_GET['task_id']) || empty($_GET['task_id'])) {
    die("Task ID is required.");
}

$task_id = $_GET['task_id'];
$conn = getConnection();

try {
    $sql = "SELECT task_id, task_name, task_desc, task_start_date, task_due_date, task_done_date, order_id FROM task WHERE task_id = :task_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        die("Task not found.");
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>