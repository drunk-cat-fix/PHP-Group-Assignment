<?php
require_once __DIR__ . '/../entities/Admin.php';
require_once __DIR__ . '/../dao/AdminDao.php';
require_once __DIR__ . '/../Utilities/Connection.php';

$staffList = [];
$conn = getConnection();
$sql = "SELECT staff_id, staff_name, staff_address, staff_email, staff_profile FROM staff";
$stmt = $conn->prepare($sql);
$stmt->execute();
$staffList = $stmt->fetchAll(PDO::FETCH_ASSOC);

function createStaff($staffName,$staffPwd, $staffAddress, $staffEmail, $staffProfile):bool {
    $conn = getConnection();
    $sql = "INSERT INTO staff (staff_name,staff_pw, staff_address, staff_email, staff_profile)".
        " VALUES (:staff_name, :staff_pw, :staff_address, :staff_email, :staff_profile)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':staff_name', $staffName);
    $stmt->bindParam(':staff_pw', $staffPwd);
    $stmt->bindParam(':staff_address', $staffAddress);
    $stmt->bindParam(':staff_email', $staffEmail);
    $stmt->bindParam(':staff_profile', $staffProfile);
    return $stmt->execute();
}

?>