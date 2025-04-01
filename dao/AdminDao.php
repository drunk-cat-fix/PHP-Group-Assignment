<?php

use entities\Admin;

require_once "../Utilities/Connection.php";

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


}
