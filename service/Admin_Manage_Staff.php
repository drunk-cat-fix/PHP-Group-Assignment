<?php
require_once __DIR__ . '\..\entities\Admin.php';
require_once __DIR__ . '\..\dao\AdminDao.php';
require_once __DIR__ . '\..\Utilities\Connection.php';

$staffList = [];
$conn = getConnection();
$sql = "SELECT staff_id, staff_name, staff_address, staff_email, staff_profile FROM staff";
$stmt = $conn->prepare($sql);
$stmt->execute();
$staffList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>