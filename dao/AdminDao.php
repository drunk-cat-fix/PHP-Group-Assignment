<?php

use entities\Admin;

require_once __DIR__ . "/../Utilities/Connection.php";

$conn = getConnection();

class AdminDao
{
    function getAllAdmins(): false|PDOStatement
    {
        $sql = "SELECT * FROM `admin`";
        $conn = getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    function updateAdminById(Admin $admin): int
    {
        $sql = "update table admin set username=?, password=?, email=?, admin_profile =?  where id=?";
        $conn = getConnection();
        $stmt = $conn->prepare($sql);
        $adminName = $admin->getAdminName();
        $stmt->bindParam(1, $adminName, PDO::PARAM_STR);
        $adminPw = $admin->getAdminPw();
        $password_hash = password_hash($adminPw, PASSWORD_DEFAULT);
        $stmt->bindParam(2, $password_hash, PDO::PARAM_STR);
        $adminEmail = $admin->getAdminEmail();
        $stmt->bindParam(3, $adminEmail, PDO::PARAM_STR);
        $adminId = $admin->getAdminId();
        $stmt->bindParam(4, $adminId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->rowCount();
        }
        return 0;
    }

    function deleteAdminById(int $id): int
    {
        $sql = "delete from admin where admin_id=?";
        $conn = getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

    function createAdmin(Admin $admin): int
    {
        $sql = "INSERT INTO admin (admin_name, admin_pw, admin_email,admin_profile) VALUES (?, ?, ?, ?)";
        $conn = getConnection();
        $stmt = $conn->prepare($sql);
        $adminName = $admin->getAdminName();
        $stmt->bindParam(1, $adminName, PDO::PARAM_STR);
        $adminPw = $admin->getAdminPw();
        $password_hash = password_hash($adminPw, PASSWORD_DEFAULT);
        $stmt->bindParam(2, $password_hash, PDO::PARAM_STR);
        $adminEmail = $admin->getAdminEmail();
        $stmt->bindParam(3, $adminEmail, PDO::PARAM_STR);
        $adminProfile = $admin->getAdminProfile();
        $stmt->bindParam(4, $adminProfile, PDO::PARAM_STR);
//        print_r($adminProfile);
        if ($stmt->execute()) {
            return $stmt->rowCount();
        } else {
            return 0;
        }
    }

    function getAdminById(int $id): Admin
    {
        $sql = "select * from admin where id=?";
        $conn = getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        $admin->setAdminId($admin["admin_id"]);
        $admin->setAdminName($admin["admin_name"]);
        $admin->setAdminPw($admin["admin_pw"]);
        $admin->setAdminEmail($admin["admin_email"]);
        $admin->setAdminProfile($admin["admin_profile"]);
        return $admin;
    }

    function isExisted(Admin $admin): int{
        $sql = "select admin_id,admin_name, admin_pw from admin where admin_name = ? ";
        $conn = getConnection();
        $stmt = $conn->prepare($sql);
        $adminName = $admin->getAdminName();
        $stmt->bindParam(1, $adminName, PDO::PARAM_STR);
        $adminPw = $admin->getAdminPw();
        $hashedPw = password_hash($adminPw, PASSWORD_DEFAULT);
        $stmt->execute();
        $adm = $stmt->fetch();
        if ($adm&&password_verify($admin->getAdminPw(), $adm["admin_pw"])) {
            $_SESSION["admin_id"] = $adm["admin_id"];
            return $stmt->rowCount();
        }
        return 0;
//        print_r($stmt->rowCount());

    }

    function updateProfileForAdmin(Admin $admin): int{
        $sql = "update admin set admin_profile =? where admin_id=? ";
        $conn = getConnection();
        $stmt = $conn->prepare($sql);
        $adminProfile = $admin->getAdminProfile();
        $stmt->bindParam(1, $adminProfile, PDO::PARAM_STR);
        $adminId = $admin->getAdminId();
        $stmt->bindParam(2, $adminId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->rowCount();
        }
        return 0;
    }


    public function loadProfileForAdmin($adminId) :Admin{
        $sql = "select admin_name,admin_profile from admin where admin_id=?";
        $conn = getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute([$adminId]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        $admin->setAdminProfile($admin["admin_profile"]);
        return $admin;
    }

    public function addTask(Admin $admin)
    {
        $conn = getConnection();  
        $taskName = $admin->getTaskName();
        $taskDesc = $admin->getTaskDesc();
        $taskStartDate = $admin->getTaskStartDate();
        $taskDueDate = $admin->getTaskDueDate();

        // Extract Order ID if task name contains "#1234"
        $orderID = null;
        if (preg_match('/#(\d+)/', $taskName, $matches)) {
            $orderID = $matches[1]; // Extracts the number after #
        }

        try {
            $conn->beginTransaction();
        
            if ($orderID) {
                $sql = "INSERT INTO task (task_name, task_desc, task_start_date, task_due_date, order_id) 
                        VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$taskName, $taskDesc, $taskStartDate, $taskDueDate, $orderID]);
                $this->changeDeliverStatus($orderID, $conn);
            } else {
                $sql = "INSERT INTO task (task_name, task_desc, task_start_date, task_due_date) 
                        VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$taskName, $taskDesc, $taskStartDate, $taskDueDate]);
            }

            $taskID = $this->getLatestTaskId();
            $assignedStaffs = $admin->getAssignedStaff();
        
            $result = $this->assignTask($taskID, $assignedStaffs);
        
            $conn->commit();
            return $result;
        } catch (Exception $e) {
            $conn->rollBack();
            return false;
        }
    }

    public function editTask(Admin $admin)
    {
        $conn = getConnection();
        $taskID = $admin->getTaskID();
        $taskName = $admin->getTaskName();
        $taskDesc = $admin->getTaskDesc();
        $taskStartDate = $admin->getTaskStartDate();
        $taskDueDate = $admin->getTaskDueDate();
    
        try {
            $conn->beginTransaction();

            // Update the task details
            $sql = "UPDATE task 
                    SET task_name = ?, task_desc = ?, task_start_date = ?, task_due_date = ? 
                    WHERE task_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$taskName, $taskDesc, $taskStartDate, $taskDueDate, $taskID]);

            // Delete existing staff_task assignments for this task
            $sql = "DELETE FROM staff_task WHERE task_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$taskID]);

            // Insert new staff_task assignments
            $assignedStaffs = $admin->getAssignedStaff();
            foreach ($assignedStaffs as $staffID) {
                $sql = "INSERT INTO staff_task (staff_id, task_id) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$staffID, $taskID]);
            }

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollBack();
            return false;
        }
    }

    public function assignTask($taskID, $assignedStaffs)
    {
        if (!$taskID || empty($assignedStaffs)) {
            return false;
        }
    
        $conn = getConnection();  
        $sql = "INSERT INTO staff_task (staff_id, task_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        foreach ($assignedStaffs as $staffId) {
            $stmt->execute([$staffId, $taskID]);
        }
        
        return true;
    }

    public function changeDeliverStatus($orderID, $conn = null)
    {
        if ($conn === null) {
            $conn = getConnection();
        }
    
        $sql = "UPDATE customer_order SET deliver_status = 'In Progress' WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$orderID]);
    }

    public function getLatestTaskId()
    {
        $conn = getConnection();
        $sql = "SELECT MAX(task_id) as latest_id FROM task";
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['latest_id'] : null;
    }

    public function removeStaff(Admin $admin)
    {
        $sql = "DELETE FROM staff WHERE staff_id = ?";
        $conn = getConnection();
        $stmt = $conn->prepare($sql);
        $staffID = $admin->getStaffID();
        if ($stmt->execute([$staffID])) {
            header("Location: ../admin_manage_staff.php?msg=Staff removed successfully");
            exit();
        } else {
            echo "<p style='color: red;'>Failed to remove staff.</p>";
        }
    }


}
