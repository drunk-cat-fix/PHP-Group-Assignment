<?php

use entities\Staff;

require_once __DIR__ . "/../Utilities/Connection.php";

class StaffDao {
    /**
     * @return array
     */
    public function getAllStaffs() {
        $sql = "SELECT * FROM staff";
        $stmt = getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getStaffById($id) {
        $sql = "SELECT * FROM staff WHERE id = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * @param $email
     * @return mixed
     */
    public function getStaffByEmail($email) {
        $sql = "SELECT * FROM staff WHERE email = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * @param Staff $staff
     * @return bool
     */
    public function addStaff(Staff $staff): bool
    {
        $sql = "INSERT INTO staff (staff_name, staff_pw, staff_email, staff_profile) VALUES (?, ?, ?,?)";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindValue(1, $staff->getStaffName());
        $hashedPwd = password_hash($staff->getStaffPw(), PASSWORD_DEFAULT);
        $stmt->bindValue(2, $hashedPwd);
        $stmt->bindValue(3, $staff->getStaffEmail());
        $staffProfile = $staff->getStaffProfile();
        $stmt->bindParam(4, $staffProfile, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * @param Staff $staff
     * @return int
     */
    public function updateStaff(Staff $staff):int {
        $sql = "UPDATE staff SET staff_name = ?, staff_pw = ?, staff_email = ? WHERE staff_id = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindValue(1, $staff->getStaffName());
        $stmt->bindValue(2, $staff->getStaffPw());
        $stmt->bindValue(3, $staff->getStaffEmail());
        $staffId = $staff->getStaffId();
        $stmt->bindParam(4, $staffId);
        return $stmt->execute();
    }

    /**
     * @param $id
     * @return int
     */
    public function deleteStaffById($id):int {
        $sql = "DELETE FROM staff WHERE id = ?";
        $stmt = getConnection()->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * @param $email
     * @return int
     */
    public function deleteStaffByEmail($email):int {
        $sql = "DELETE FROM staff WHERE email = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->execute();
    }

    /**
     * @param Staff $staff
     * @return int
     */
    public function updateProfileForStaff(Staff $staff):int {
        $sql = "UPDATE staff SET staff_profile = ? WHERE staff_id = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindValue(1, $staff->getStaffProfile());
        $stmt->bindValue(2, $staff->getStaffId());
        return $stmt->execute();
    }

    /**
     * @param $uName
     * @param $uPwd
     * @return bool
     */
    public function isExisted($uName, $uPwd){
        $sql = "SELECT staff_id, staff_name, staff_pw FROM staff WHERE staff_name = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->execute([$uName]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($uPwd, $row['staff_pw'])) {
            return ['staff_id' => $row['staff_id']]; // Return staff_id instead of true
        }
        return false;
    }

    public function loadProfileForStaff($staffId){
        $sql = "SELECT staff_profile FROM staff WHERE staff_id = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->execute([$staffId]);
        $staff=$stmt->fetch(PDO::FETCH_ASSOC);
        $staff->setStaffProfile($staff['staff_profile']);
        return $staff;
    }

    public function updateTaskStatus($taskIds) {
        $conn = getConnection();
        $conn->beginTransaction();

        try {
            $today = date('Y-m-d');

            foreach ($taskIds as $taskId) {
                // Check if this task is linked to an order and verify progress is 100%
                $sql = "SELECT t.order_id, IFNULL(co.deliver_percent, 0) as deliver_percent 
                        FROM task t 
                        LEFT JOIN customer_order co ON t.order_id = co.order_id 
                        WHERE t.task_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$taskId]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
                // Skip tasks with orders that don't have 100% progress
                if ($result['order_id'] && $result['deliver_percent'] < 100) {
                    continue;
                }
            
                // Update task_done_date in the task table
                $sql = "UPDATE task SET task_done_date = ? WHERE task_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$today, $taskId]);

                if ($result['order_id']) {
                    // Update deliver_date and deliver_status in customer_order table
                    $sql = "UPDATE customer_order SET deliver_date = ?, deliver_status = 'Delivered', isInProgress = FALSE, isDelivered = TRUE, isRead = FALSE WHERE order_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$today, $result['order_id']]);
                }
            }

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollBack();
            return false;
        }
    }
    
    /**
     * Update delivery progress percentages for orders
     * 
     * @param array $progressUpdates Array of objects with order_id and progress values
     * @return bool Success or failure
     */
    public function updateDeliveryProgress($progressUpdates) {
        $conn = getConnection();
        $conn->beginTransaction();

        try {
            foreach ($progressUpdates as $update) {
                $sql = "UPDATE customer_order SET deliver_percent = ?, isInProgress = FALSE, isDelivered = TRUE WHERE order_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$update['progress'], $update['order_id']]);
            }

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollBack();
            return false;
        }
    }

    public function addVendor($staff)
    {
        $vendorName = $staff->getVendorName();
        $vendorDesc = $staff->getVendorDesc();
        $shopName = $staff->getShopName();
        $shopAddress = $staff->getShopAddress();
        $shopCity = $staff->getShopCity();
        $shopState = $staff->getShopState();
        $vendorProfile = $staff->getVendorProfile();
        $vendorEmail = $staff->getVendorEmail();
        $conn = getConnection();
        $conn->beginTransaction();
        try {
            $sql = "INSERT INTO vendor (vendor_name, vendor_desc, shop_name, shop_address, shop_city, shop_state, vendor_profile, vendor_email, vendor_pw, vendor_tier) VALUES (?, ?, ?, ?, ?, ?, ?, ?, '123', 'Bronze')";            $stmt = $conn->prepare($sql);
            $stmt->execute([$vendorName, $vendorDesc, $shopName, $shopAddress, $shopCity, $shopState, $vendorProfile, $vendorEmail]);
            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollBack();
            return false;
        }
    }

    function updateVendorTier($vendorId, $tier) {
        try {
            $conn = getConnection();

            // Prepare the SQL statement to update the vendor tier
            $sql = "UPDATE vendor SET vendor_tier = :tier WHERE vendor_id = :vendor_id";
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':tier', $tier, PDO::PARAM_STR);
            $stmt->bindParam(':vendor_id', $vendorId, PDO::PARAM_INT);

            // Execute the update statement
            $stmt->execute();

            // Check if the update was successful
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Handle any errors (e.g., database issues)
            error_log($e->getMessage());
            return false;
        }
    }

}