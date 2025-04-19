<?php
use entities\Staff;
require_once __DIR__ . '\..\entities\Admin.php';
require_once __DIR__ . '\..\dao\AdminDao.php';
require_once __DIR__ . '\..\Utilities\Connection.php';
require_once __DIR__ . '\..\entities\Staff.php';
require_once __DIR__ . '\..\dao\StaffDao.php';

if ($_POST) {
    $staff = new Staff();
    $staff->setVendorName($_POST['vendor_name']);
    $staff->setVendorDesc($_POST['vendor_description']);
    $staff->setShopName($_POST['shop_name']);
    $staff->setShopAddress($_POST['shop_address']);
    $staff->setShopCity($_POST['shop_city']);
    $staff->setShopState($_POST['shop_state']);
    $target = $_FILES['profile']['tmp_name'];
    $file = fopen($target, "rb");
    $size = filesize($target);
    $content = fread($file, $size);
    $staff->setVendorProfile($content);
    $staff->setVendorEmail($_POST['vendor_email']);
    $staffDao = new StaffDao();
    $action = $staffDao->addVendor($staff);
    if ($action) {
        header("location: ../system_vendor_list.php");
    } else {
        header("location: ../system_vendor_list.php?errMsg=Failed to add task!");
    }
}

?>