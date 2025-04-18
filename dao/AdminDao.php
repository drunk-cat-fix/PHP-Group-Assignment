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
        // Use our debug log function if it exists
        if (function_exists('debug_log')) {
            debug_log("AdminDao::addTask method started");
        } else {
            error_log("AdminDao::addTask method started");
        }

        $conn = getConnection();  
        $taskName = $admin->getTaskName();
        $taskDesc = $admin->getTaskDesc();
        $taskStartDate = $admin->getTaskStartDate();
        $taskDueDate = $admin->getTaskDueDate();
        $assignedStaffs = $admin->getAssignedStaff();
        $orderID = $admin->getOrderID(); // Get the order_id directly

        // Log task details
        debug_log("Task details - Name: $taskName, Start: $taskStartDate, Due: $taskDueDate");
        if ($orderID) {
            debug_log("Task is associated with order ID: $orderID");
        }
        debug_log("Staff assignment count: " . count($assignedStaffs));

        if (is_array($assignedStaffs)) {
            debug_log("Staff IDs for assignment: " . implode(', ', $assignedStaffs));
        } else {
            debug_log("ERROR: assignedStaffs is not an array!");
        }

        try {
            debug_log("Starting transaction");
            $conn->beginTransaction();

            // Create the task with or without order_id
            if ($orderID) {
                $sql = "INSERT INTO task (task_name, task_desc, task_start_date, task_due_date, order_id) 
                        VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$taskName, $taskDesc, $taskStartDate, $taskDueDate, $orderID]);
                debug_log("Task inserted with order_id=$orderID");
            
                // Update order status
                $this->changeDeliverStatus($orderID, $conn);
                debug_log("Order delivery status updated for order ID: $orderID");
            } else {
                $sql = "INSERT INTO task (task_name, task_desc, task_start_date, task_due_date) 
                        VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$taskName, $taskDesc, $taskStartDate, $taskDueDate]);
                debug_log("Task inserted without order_id");
            }

            $taskID = $conn->lastInsertId();
            debug_log("Generated task ID: $taskID");
    
            // Commit the task creation
            $conn->commit();
            debug_log("Transaction committed for task creation");
    
            // Now handle staff assignment
            if (!empty($assignedStaffs)) {
                debug_log("Attempting to assign " . count($assignedStaffs) . " staff member(s) to task");
                $staffAssignResult = $this->assignTask($taskID, $assignedStaffs);
                debug_log("Staff assignment result: " . ($staffAssignResult ? "SUCCESS" : "FAILED"));
                return $staffAssignResult;
            } else {
                debug_log("No staff to assign, task created successfully without staff");
                return true;
            }

        } catch (Exception $e) {
            debug_log("ERROR in addTask: " . $e->getMessage());
            $conn->rollBack();
            debug_log("Transaction rolled back");
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
        if (function_exists('debug_log')) {
            debug_log("assignTask method called with taskID=$taskID");
        } else {
            error_log("assignTask method called with taskID=$taskID");
        }
    
        if (!$taskID) {
            debug_log("Invalid taskID (empty/null)");
            return false;
        }
    
        if (empty($assignedStaffs)) {
            debug_log("No staff IDs provided for assignment");
            return false;
        }
    
        if (!is_array($assignedStaffs)) {
            debug_log("ERROR: assignedStaffs is not an array type: " . gettype($assignedStaffs));
            return false;
        }
    
        debug_log("Staff IDs to assign: " . implode(", ", $assignedStaffs));

        try {
            $conn = getConnection();
            debug_log("Starting transaction for staff assignment");
            $conn->beginTransaction();
        
            $sql = "INSERT INTO staff_task (staff_id, task_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
        
            $successCount = 0;
            foreach ($assignedStaffs as $staffId) {
                debug_log("Attempting to assign staff ID $staffId to task ID $taskID");
            
                try {
                    $result = $stmt->execute([$staffId, $taskID]);
                    if ($result) {
                        debug_log("Successfully assigned staff ID $staffId");
                        $successCount++;
                    } else {
                        debug_log("Failed to execute statement for staff ID $staffId");
                        // Get database error info
                        $errorInfo = $stmt->errorInfo();
                        debug_log("SQL Error: " . implode(" | ", $errorInfo));
                    }
                } catch (PDOException $e) {
                    debug_log("PDO Exception assigning staff: " . $e->getMessage());
                }
            }

            if ($successCount > 0) {
                debug_log("Successfully assigned $successCount staff members, committing transaction");
                $conn->commit();
                return true;
            } else {
                debug_log("No staff assignments succeeded, rolling back");
                $conn->rollBack();
                return false;
            }
        } catch (Exception $e) {
            debug_log("ERROR in assignTask: " . $e->getMessage());
            if (isset($conn)) {
                $conn->rollBack();
                debug_log("Transaction rolled back");
            }
            return false;
        }
    }

    public function changeDeliverStatus($orderID, $conn = null)
    {
        if ($conn === null) {
            $conn = getConnection();
        }
    
        $sql = "UPDATE customer_order SET deliver_status = 'In Progress', isPending = FALSE, isInProgress = TRUE, isRead = FALSE WHERE order_id = ?";
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
