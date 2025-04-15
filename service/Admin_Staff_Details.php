<?php
use entities\Admin;
require_once __DIR__ . '\..\entities\Admin.php';
require_once __DIR__ . '\..\dao\AdminDao.php';
require_once __DIR__ . '\..\Utilities\Connection.php';

$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_staff']) && isset($_POST['staff_id'])) {
        $admin = new Admin();
        $admin->setStaffID($_POST['staff_id']);
        $adminDao = new AdminDao();
        $action = $adminDao->removeStaff($admin);
        if ($action) {
            header("Location: ../admin_manage_staff.php");
            exit;
        } else {
            header("Location: ../admin_add_task.php?errMsg=Failed to remove staff!");
            exit;
        }
    } else {
        die("Invalid remove request.");
    }
}

// Otherwise: GET request to load staff info
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid staff ID.");
}

$staff_id = $_GET['id'];

$sql = "SELECT * FROM staff WHERE staff_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$staff_id]);
$staff = $stmt->fetch(PDO::FETCH_ASSOC);
