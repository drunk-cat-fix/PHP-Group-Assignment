<?php
class VendorDao {
    /**
     * @return array
     */
    public function getAllVendors() {
        $sql = "SELECT * FROM vendors";
        $stmt = getConnection()->prepare($sql);
        $stmt->execute();
        $vendors = $stmt->fetchAll();
        return $vendors;
    }

    /**
     * @param $id
     * @return bool
     */
    public function getVendorById($id) {
        $sql = "SELECT * FROM vendors WHERE id = :id";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    /**
     * @param $email
     * @return bool
     */
    public function getVendorByEmail($email) {
        $sql = "SELECT * FROM vendors WHERE email = :email";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":email", $email);
        return $stmt->execute();
    }

    /**
     * @param $vendor
     * @return bool
     */
    public function addVendor($vendor) :bool {
        $sql = "INSERT INTO vendor (vendor_name, vendor_pw, vendor_email, vendor_profile) VALUES (:name, :pw, :email, :profile)";

        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":name", $vendor->getVendorName());
        $stmt->bindParam(":email", $vendor->getVendorEmail());
        $hashedPw = password_hash($vendor->getVendorPw(), PASSWORD_DEFAULT);
        $stmt->bindParam(":pw", $hashedPw);
        $stmt->bindParam(":profile", $vendor->getVendorProfile());
        return $stmt->execute();
    }

    /**
     * @param $vendor
     * @return bool
     */
    public function updateVendor($vendor) {
        $sql = "update vendors set vendor_name = :name, vendor_email = :email, vendor_profile = :profile where vendor_id = :id";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":name", $vendor->getVendorName());
        $stmt->bindParam(":email", $vendor->getVendorEmail());
        $stmt->bindParam(":profile", $vendor->getVendorProfile());
        $stmt->bindParam(":id", $vendor->getId());
        return $stmt->execute();
    }

    public function deleteVendor($id) {
        $sql = "DELETE FROM vendors WHERE id = :id";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function updateProfileForVendor($vendor) {
        $sql = "UPDATE vendors set vendor_profile = :profile where vendor_id = :id";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":profile", $vendor->getVendorProfile());
        $stmt->bindParam(":id", $vendor->getId());
        return $stmt->execute();
    }

    public function isExisted($uName,$uPwd): bool
    {
        $sql = "SELECT vendor_id,vendor_name, vendor_pw FROM vendor WHERE vendor_name = :uName";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":uName", $uName);
        $stmt->execute();
        $vendor = $stmt->fetch();
//        var_dump($vendor&&password_verify($uPwd, $vendor->getVendorPw()));
        if ($vendor&&password_verify($uPwd, $vendor['vendor_pw'])) {
            $_SESSION['vendor_id'] = $vendor['vendor_id'];
            return true;
        }
        return false;
    }

    public function loadProfileForVendor($vendorId)
    {
        $sql = "SELECT vendor_profile FROM vendors WHERE vendor_id = :id";
        $stmt = getConnection()->prepare($sql);
        $stmt->bindParam(":id", $vendorId);
        $stmt->execute();
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);
        $profile->setVendorProfile($profile['vendor_profile']);
        return $profile;
    }




}