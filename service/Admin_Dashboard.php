<?php
require_once 'Utilities/Connection.php';

$staffList = [];
$conn = getConnection();
$sql = "SELECT staff_id, staff_name, staff_address, staff_email FROM staff";
$stmt = $conn->prepare($sql);
$stmt->execute();
$staffList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>