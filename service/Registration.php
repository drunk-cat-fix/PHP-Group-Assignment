<?php

use entities\Admin;
use entities\Customer;
use entities\Staff;
use entities\Vendor;


require_once '../entities/Admin.php';
require_once '../dao/AdminDAO.php';
require_once '../dao/CustomerDao.php';
require_once '../entities/Customer.php';
require_once '../dao/StaffDao.php';
require_once '../entities/Staff.php';
require_once '../dao/VendorDao.php';
require_once '../entities/Vendor.php';

if ($_POST) {
    $role = $_POST['role'];
    if ($role == 'Vendor') {
        $vendor = new Vendor();
        $vendor->setVendorName($_POST['username']);
        $vendor->setVendorEmail($_POST['email']);
        $vendor->setVendorPw($_POST['password']);
        if (!empty($_FILES['profile']['tmp_name'])) {
            $target = $_FILES['profile']['tmp_name'];
            $imageData = file_get_contents($target); // Use file_get_contents instead of fopen/fread
    
            // Don't use addslashes on binary data
            $vendor->setVendorProfile($imageData); // Replace 'entity' with vendor/customer/staff/admin
        }
        $vendorDao = new VendorDao();
        if ($vendorDao->addVendor($vendor)) {
            header('Location: ../login.php');
        }else{
            echo "<script language='javascript'>alert('Create customer error')</script>";
        }
    }

    if ($role == 'Customer') {
        $customer = new Customer();
        $customer->setCustomerName($_POST['username']);
        $customer->setCustomerEmail($_POST['email']);
        $customer->setCustomerPw($_POST['password']);
        if (!empty($_FILES['profile']['tmp_name'])) {
            $target = $_FILES['profile']['tmp_name'];
            $imageData = file_get_contents($target); // Use file_get_contents instead of fopen/fread
    
            // Don't use addslashes on binary data
            $customer->setCustomerProfile($imageData); // Replace 'entity' with vendor/customer/staff/admin
        }
        $customerDao = new CustomerDao();
        if ($customerDao->addCustomer($customer)) {
            header("location: ../login.php");
        }else{
            echo "<script language='javascript'>alert('Create customer error')</script>";
        }
    }

    if ($role == 'Staff') {
        $staff = new Staff();
        $staff->setStaffName($_POST['username']);
        $staff->setStaffEmail($_POST['email']);
        $staff->setStaffPw($_POST['password']);
        if (!empty($_FILES['profile']['tmp_name'])) {
            $target = $_FILES['profile']['tmp_name'];
            $imageData = file_get_contents($target); // Use file_get_contents instead of fopen/fread
    
            // Don't use addslashes on binary data
            $staff->setStaffProfile($imageData); // Replace 'entity' with vendor/customer/staff/admin
        }
        $staffDao = new StaffDao();
        if ($staffDao->addStaff($staff)) {
            header("location: ../login.php");
        }else{
            echo "<script language='javascript'>alert('Create staff error')</script>";
        }
    }

    if ($role == 'Admin') {
        $admin = new Admin();
        $admin->setAdminName($_POST['username']);
        $admin->setAdminEmail($_POST['email']);
        $admin->setAdminPw($_POST['password']);
        if (!empty($_FILES['profile']['tmp_name'])) {
            $target = $_FILES['profile']['tmp_name'];
            $imageData = file_get_contents($target); // Use file_get_contents instead of fopen/fread
    
            // Don't use addslashes on binary data
            $admin->setAdminProfile($imageData); // Replace 'entity' with vendor/customer/staff/admin
        }

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