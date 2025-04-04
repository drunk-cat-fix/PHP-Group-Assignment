<?php
session_start();
use entities\Admin;
require_once __DIR__ . '\..\entities\Admin.php';
require_once __DIR__ . '\..\dao\AdminDao.php';
require_once __DIR__ . '\..\Utilities\Connection.php';
$conn = getConnection();

$sql = "SELECT task_id, task_name, task_desc, task_start_date, task_due_date, task_done_date, order_id FROM task";
$stmt = $conn->prepare($sql);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>