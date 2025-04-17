<?php
require_once __DIR__ . '/../entities/Admin.php';
require_once __DIR__ . '/../dao/AdminDao.php';
require_once __DIR__ . '/../Utilities/Connection.php';

$staffList = [];
$conn = getConnection();
$sql = "
SELECT 
    s.staff_id,
    s.staff_name,
    s.staff_address,
    s.staff_email,
    COUNT(st.task_id) AS tasks_assigned,
    SUM(CASE WHEN t.task_done_date IS NOT NULL THEN 1 ELSE 0 END) AS tasks_completed,
    SUM(CASE 
            WHEN t.task_done_date IS NULL AND t.task_due_date < CURDATE() THEN 1 
            ELSE 0 
        END) AS overdue_tasks,
    ROUND(
        CASE 
            WHEN COUNT(st.task_id) = 0 THEN 0
            ELSE (SUM(CASE WHEN t.task_done_date IS NOT NULL THEN 1 ELSE 0 END) / COUNT(st.task_id)) * 100
        END, 1
    ) AS completion_rate
FROM 
    staff s
LEFT JOIN 
    staff_task st ON s.staff_id = st.staff_id
LEFT JOIN 
    task t ON st.task_id = t.task_id
GROUP BY 
    s.staff_id, s.staff_name, s.staff_address, s.staff_email
";
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