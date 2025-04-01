<?php

use entities\Staff;

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
        $stmt->bindParam(4, $staffProfile);
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
    public function isExisted($uName,$uPwd){
        $sql = "SELECT staff_id,staff_name,staff_pw FROM staff WHERE staff_name = ?";
        $stmt = getConnection()->prepare($sql);
        $stmt->execute([$uName]);
        $row= $stmt->fetch();
        if($row&&password_verify($uPwd, $row['staff_pw'])){
            $_SESSION['staff_id'] = $row['staff_id'];
            return true;
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


}