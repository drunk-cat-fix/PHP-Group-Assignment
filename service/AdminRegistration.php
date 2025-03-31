<?php

use entities\Admin;
use entities\Customer;
use entities\Staff;
use entities\Vendor;

require_once '../entities/Admin.php';
require_once '../dao/AdminDAO.php';

if ($_POST) {
    $role = $_POST['role'];
    if ($role == 'Vendor') {
        $vendor = new Vendor();
        $vendor->setVendorName($_POST['username']);
        $vendor->setVendorEmail($_POST['email']);
        $vendor->setVendorPw($_POST['password']);
    }

    if ($role == 'Customer') {
        $customer = new Customer();
        $customer->setCustomerName($_POST['username']);
        $customer->setCustomerEmail($_POST['email']);
        $customer->setCustomerPw($_POST['password']);
    }

    if ($role == 'Staff') {
        $staff = new Staff();
        $staff->setStaffName($_POST['username']);
        $staff->setStaffEmail($_POST['email']);
        $staff->setStaffPw($_POST['password']);
    }

    if ($role == 'Admin') {
        $admin = new Admin();
        $admin->setAdminName($_POST['username']);
        $admin->setAdminEmail($_POST['email']);
        $admin->setAdminPw($_POST['password']);
//        print_r($_FILES['profile']);
        $target = $_FILES['profile']['tmp_name'];
        $file = fopen($target, "rb");
        $size = filesize($target);
        $content = fread($file, $size);
        $content = addslashes($content);
        $admin->setAdminProfile($content);

//        print_r($admin->getAdminProfile());
        $adminDao = new AdminDao();
        $status = $adminDao->createAdmin($admin);
        if (!$status) {
            echo "<script>alert('Error creating admin ! ')</script>";
        }else{
            echo "<script>alert('Creating admin successfully ! ')</script>";
            header('Location: ../login.php');
        }
    }
}