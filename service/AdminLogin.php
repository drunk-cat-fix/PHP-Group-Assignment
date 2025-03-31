<?php

use entities\Admin;
use entities\Customer;
use entities\Staff;
use entities\Vendor;

require_once '../entities/Admin.php';
require_once '../dao/AdminDAO.php';

if ($_POST) {
    $role = $_POST['roles'];
//    print_r($_POST);
    if ($role == 'vendor') {
        $vendor = new Vendor();
        $vendor->setVendorName($_POST['username']);
        $vendor->setVendorEmail($_POST['email']);
        $vendor->setVendorPw($_POST['password']);
    }

    if ($role == 'customer') {
        $customer = new Customer();
        $customer->setCustomerName($_POST['username']);
        $customer->setCustomerEmail($_POST['email']);
        $customer->setCustomerPw($_POST['password']);
    }

    if ($role == 'staff') {
        $staff = new Staff();
        $staff->setStaffName($_POST['username']);
        $staff->setStaffEmail($_POST['email']);
        $staff->setStaffPw($_POST['password']);
    }

    if ($role == 'admin') {
        $admin = new Admin();
        $admin->setAdminName($_POST['username']);
        $admin->setAdminPw($_POST['password']);
        $adminDao = new AdminDao();
        $status = $adminDao->isExisted($admin);
//        print_r($status);
        if ($status) {
            header("location: ../index.php");
        } else {
            header("location: ../login.php?errMsg=Invalid username or password");
        }

    }

    if ($role == '') {
        header("location: ../login.php");
    }

}